import { appState, block, unblock } from './library.js';

const { reactive, ref, createApp, onMounted, nextTick, computed } = Vue;

const chat = createApp({
	setup() {
		const controller = ref(new AbortController());
		const messages = ref([]);
		const messageModel = ref([]);
		const chatbot = ref(app.chatbot);
		const chatbotPhotoUrl = ref(app.chatbotPhotoUrl);

		const TYPE_CHATBOT = 0;
	    const TYPE_USER = 1;

		const initData = () => {
			block('#chatbot', 'Initializing Data...');

			$.ajax({
				url: app.baseUrl + 'site/init-chatbot-data',
				method: 'get',
				dataType: 'json',
				success: (s) => {
					messages.value = s.messages || [];
					unblock('#chatbot');

					// scrollToBottom();
					// poll();
				},
				error: (e) => {
					console.log(e)
					unblock('chatbot');
				}
			})
		}

		const sendNewMessage = () => {
			// const content = _content ? _content: messageForm.value.content;
			// const attachments = _attachments ? _attachments: [];

			// if (content || attachments.length) {
			// 	messageFormState.isSending = true;

			// 	let contentPlaceholder = '';
			// 	if (content) {
			// 		if (attachments.length) {
			// 			contentPlaceholder = 'Sending "' + truncateString(content) + '" with ' + attachments.length + ' attachments';
			// 		}
			// 		else {
			// 			contentPlaceholder = truncateString(content);
			// 		}
			// 	}
			// 	else {
			// 		contentPlaceholder = 'Sending ' + attachments.length + ' attachments';
			// 	}
			// 	messageFormState.content.push(contentPlaceholder);

			// 	resetMessageForm();
			// 	scrollToBottom();
			$.ajax({
				url: app.baseUrl + 'site/send-new-message',
				data: {message: messageModel.value},
				dataType: 'json',
				method: 'post',
				success: (s) => {
					if (s.status == 'success') {
			    		
			    	}
					unblock('.messages-body');
				},
				error: (e) => {
					unblock('.messages-body');
					// messageFormState.isSending = false;
				}
			})
		}

		const messageClass = (message) => {
			return message.type == TYPE_CHATBOT ? 'user': 'self';
		}

		onMounted(() => {
			initData();
		});

		return {
			messages,
			chatbot,
			chatbotPhotoUrl,
			messageClass,
			sendNewMessage,
			messageModel
		}
	}
});
chat.mount('#chatbot');


