import { appState, block, unblock } from './library.js';

const { reactive, ref, createApp, onMounted, nextTick, computed } = Vue;

const chat = createApp({
	setup() {
		const messages = ref([]);
		const messageModel = ref('');
		const chatbot = ref(app.chatbot);
		const chatbotPhotoUrl = ref(app.chatbotPhotoUrl);
		const totalMessages = ref(0);
		const conversationsContainer = ref('');
		const messageFormState = reactive({
			isSending: false,
			content: []
		});

		const showScrollable = ref(false);

		const minimumMessageId = ref(1);


		const TYPE_CHATBOT = 0;
	    const TYPE_USER = 1;

		const initData = () => {
			block('#chatbot', 'Initializing Data...');

			$.ajax({
				url: app.baseUrl + 'site/init-chatbot-data',
				method: 'get',
				dataType: 'json',
				success: (response) => {
					messages.value = response.messages || [];
					totalMessages.value = response.totalMessages;
					minimumMessageId.value = response.minimumMessageId || 1;

					unblock('#chatbot');

					scrollToBottom();
					poll();
				},
				error: (e) => {
					console.log(e)
					unblock('#chatbot');
				}
			})
		}

		const hasWhiteSpace = (str) => {
		  	return str.trim().length === 0;
		}

		const sendNewMessage = (hiddenMessage='') => {
			if (messageModel.value) {
				let message = messageModel.value;

				if (hasWhiteSpace(message)) {
					return;
				}
				messageModel.value = '';

				messageFormState.isSending = true;
				messageFormState.content.push(message);

				scrollToBottom();
				$.ajax({
					url: app.baseUrl + 'site/send-new-message',
					data: {
						message,
						hiddenMessage
					},
					dataType: 'json',
					method: 'post',
					success: (response) => {
						if (response.status == 'success') {
				    		
				    	}
						unblock('.messages-body');
					},
					error: (e) => {
						unblock('.messages-body');
						messageFormState.isSending = false;
					}
				})
			}
		}

		const poll = () => {
			$.ajax({
				url: app.baseUrl + 'site/chat-poll',
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

					messageFormState.isSending = false;
					messageFormState.content = [];
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

		const messageClass = (message) => {
			return message.type == TYPE_CHATBOT ? 'user': 'self';
		}

		const messageStyle = (message) => {
			return message.type == TYPE_CHATBOT ? {}: {background: chatbot.value.theme_color};
		}

		const messageStyleClass = (index) => {
			let addedClass = '';
			let currentMessage = messages.value[index];
			let nextMessage = messages.value[index + 1];
			if (nextMessage) {
				if (currentMessage.type == nextMessage.type && currentMessage.timeSent == nextMessage.timeSent) {
					addedClass += 'mb-1 bblr0';
				}
			}

			if (index == 0) {
				return addedClass;
			}

			let previousMessage = messages.value[index - 1];
			if (currentMessage.type == previousMessage.type && currentMessage.timeSent == previousMessage.timeSent) {
				addedClass += ' btlr0';
			}


			return addedClass;
		}


		const scrollToBottom = (force = true) => {
	  		nextTick(() => {
	  			if (force) {
	  				// conversationsContainer.value.scrollTo({
  					// 	top: conversationsContainer.value.scrollHeight,
  					// 	behavior: 'smooth'
  					// });
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

		const messageScroll = (e) => {

		    if (e.target.scrollTop == 0 && isScrollable(e.target)) {
	    		const minMessageId = Math.min(...messages.value.map(message => message.id));
	    		const lastMessageElement = document.getElementById('message-id-' + minMessageId);

		    	if (minMessageId > minimumMessageId.value) {
			    	block('.chat-box-body', 'Loading Messages...');

			    	$.ajax({
			    		url: app.baseUrl + 'site/load-previous-messages',
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

		onMounted(() => {
			initData();
			$("#chat-circle").click(function() {    
			    $("#chat-circle").toggle('scale');
			    $(".chat-box").toggle('scale');
			    scrollToBottom();
			})
			$(".chat-box-toggle").click(function() {
			    $("#chat-circle").toggle('scale');
			    $(".chat-box").toggle('scale');
			})

			$(document).on('click', '.btn-hidden-message',  function(e) {
				e.preventDefault();
				messageModel.value = $(this).data('message');
				sendNewMessage($(this).data('hidden_message'));
			});
		});

		const showTimesent = (index) => {
			if (index == 0) {
				return true;
			}

			let currentMessage = messages.value[index];
			let previousMessage = messages.value[index - 1];

			if (currentMessage.type == previousMessage.type && currentMessage.timeSent == previousMessage.timeSent) {
				return false;
			}

			return true;
		}

		return {
			messages,
			chatbot,
			chatbotPhotoUrl,
			messageClass,
			sendNewMessage,
			messageModel,
			conversationsContainer,
			messageScroll,
			messageFormState,
			messageStyle,
			showScrollable,
			scrollToBottom,
			showTimesent,
			messageStyleClass
		}
	}
});
chat.mount('#chatbot');


