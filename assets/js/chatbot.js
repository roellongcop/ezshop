import { appState, block, unblock } from '../frontend/js/library.js';
const { reactive, ref, createApp, onMounted, nextTick, computed } = Vue;

const chat = createApp({
	setup() {
		const session_id = ref(document.getElementById('live-chat').dataset.session_id)
		const messages = ref([]);
		const totalMessages = ref(0);
		const minimumMessageId = ref(1);

		const conversationsContainer = ref('');

		const TYPE_CHATBOT = 0;
	    const TYPE_USER = 1;

		const showScrollable = ref(false);

		const initData = () => {
			block('#live-chat', 'Initializing Data...');

			$.ajax({
				url: app.baseUrl + 'site/init-chatbot-data',
				method: 'get',
				data: {session_id: session_id.value},
				dataType: 'json',
				success: (response) => {
					messages.value = response.messages || [];
					totalMessages.value = response.totalMessages;
					minimumMessageId.value = response.minimumMessageId || 1;

					unblock('#live-chat');

					scrollToBottom();
					poll();
				},
				error: (e) => {
					console.log(e)
					unblock('#live-chat');
				}
			})
		}


		const poll = () => {
			$.ajax({
				url: app.baseUrl + 'site/chat-poll?session_id=' + session_id.value,
				data: chatState(),
				dataType: 'json',
				method: 'post',
				success: (response) => {
					if (response.status == 'success') {
			       		if ("totalMessages" in response) {
							totalMessages.value = response.totalMessages || 0;
						}

						if ("messages" in response) {
							let sm = messages.value.concat(response.messages);
							messages.value = sm;
						}
			       	}

			  		scrollToBottom(false);
			       	poll();
				},
				error: (e) => {
		    		console.log(e);
				}
			})
		}

		const chatState = () => {
			return {
				maxMessageId: Math.max(...messages.value.map(message => message.id)),
				// minMessageId: Math.min(...messages.value.map(message => message.id)),
				totalMessages: totalMessages.value
			}
		}

		const scrollToBottom = (force = true) => {
	  		nextTick(() => {
	  			if (force) {
  					conversationsContainer.value.scrollTop = conversationsContainer.value.scrollHeight;
	  			}
	  			else {
	  				if(conversationsContainer.value.scrollHeight - conversationsContainer.value.scrollTop <= 1000) {
	  					conversationsContainer.value.scrollTo({
	  						top: conversationsContainer.value.scrollHeight,
	  						behavior: 'smooth'
	  					});
		  				// conversationsContainer.value.scrollTop = conversationsContainer.value.scrollHeight;
	  				}
	  			}
			});
		}

		const messageScroll = (e) => {

		    if (e.target.scrollTop == 0 && isScrollable(e.target)) {
	    		const minMessageId = Math.min(...messages.value.map(message => message.id));
	    		const lastMessageElement = document.getElementById('message-id-' + minMessageId);

		    	if (minMessageId > minimumMessageId.value) {
			    	block('.chat-box-body', 'Loading Messages...');

			    	$.ajax({
			    		url: app.baseUrl + 'site/load-previous-messages?session_id=' + session_id.value,
			    		data: {minMessageId},
			    		method: 'post',
			    		dataType: 'json',
			    		success: (response) => {
			    			if (response.status == 'success') {
					    		const sm = response.messages.concat(messages.value);
					    		messages.value = sm;

					    		nextTick(() => {
					    			conversationsContainer.value.scrollTop = lastMessageElement.offsetTop;
					    		});
					    	}
							unblock('.chat-box-body');
			    		},
			    		error: (e) => {
							unblock('.chat-box-body',);
			    			console.log(e)
			    		}
			    	})
		    	}
		    }

		    if(conversationsContainer.value.scrollHeight - conversationsContainer.value.scrollTop > 1000) {
		    	showScrollable.value = true;
		    }
		    else {
		    	showScrollable.value = false;
		    }
		}

		const isScrollable = (ele) => {
		    // Compare the height to see if the element has scrollable content
		    const hasScrollableContent = ele.scrollHeight > ele.clientHeight;

		    // It's not enough because the element's `overflow-y` style can be set as
		    // * `hidden`
		    // * `hidden !important`
		    // In those cases, the scrollbar isn't shown
		    const overflowYStyle = window.getComputedStyle(ele).overflowY;
		    const isOverflowHidden = overflowYStyle.indexOf('hidden') !== -1;

		    return hasScrollableContent && !isOverflowHidden;
		}


		const setContainerClass = (message) => {
			if (message.type == TYPE_CHATBOT) {
				return 'align-items-start';
			}

			return 'align-items-end';
		}

		const setMessageClass = (message) => {
			if (message.type == TYPE_CHATBOT) {
				return 'bg-light-success  text-left';
			}

			return 'bg-light-primary text-right';
		}

		onMounted(() => {
			initData()
		});


		return {
			setContainerClass,
			setMessageClass,
			messages,
			conversationsContainer,
			showScrollable,
			messageScroll,
			scrollToBottom
		}
	}
});
chat.mount('#live-chat');
