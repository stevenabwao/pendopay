export const apiDomain = "http://127.0.0.1:8000/";
export const apiVersion = "api/v1/";
export const apiUrl = apiDomain + apiVersion;
export const loginUrl = apiDomain + "oauth/token";
export const userUrl = apiDomain + "api/user";

export const userConversationUrl = apiUrl + "getUserConversation";
export const chatNotificationsUrl = apiUrl + "chat/notifications";

export const addPostUrl = apiUrl + "post/create";
export const getPostsUrl = apiUrl + "getPosts";
export const getCurrentStatusUrl = apiUrl + "getStatus";

/*users*/
export const getUserUrl = apiUrl + "user";
export const addUserUrl = apiUrl + "user/create";
export const userListUrl = apiUrl + "userList";

/*comments*/
export const addCommentUrl = apiUrl + "comment/create";
export const getCommentsUrl = apiUrl + "getComments";

/*likes*/
export const addLikeUrl = apiUrl + "like/create";
export const getLikesUrl = apiUrl + "getLikes";
export const getPostLikesUrl = apiUrl + "post/{id}/Likes";


export const addChatToConversationUrl = apiUrl + "chatMessage/create";

export const getHeader = function () {
	const tokenData = JSON.parse(window.localStorage.getItem('authUser'))
	let headers = ''
	if (tokenData !== null) { 
		headers = {
			'Accept': 'application/json',
			'Authorization': 'Bearer ' + tokenData.access_token
		}
	}
	return headers
}