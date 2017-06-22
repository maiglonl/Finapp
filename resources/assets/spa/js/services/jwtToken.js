import {Jwt} from './resources';
import localStorage from './localStorage';

const TOKEN = 'token';

export default {
	get token(){
		return localStorage.get(TOKEN);
	},
	set token(value){
		return value ? localStorage.set(TOKEN, value) : localStorage.remove(TOKEN);
	},
	accessToken(email, password){
		return Jwt.accessToken(email, password).then((response) => {
			this.token = response.data.token;
			return response
		});
	},
	refreshToken(){
		return Jwt.refreshToken().then((response) => {
			this.token = response.data.token;
			return response;
		});
	},
	revokeToken(){
		let afterRevokeToken = (response) => {
			this.token = null;
			return response;
		};

		return Jwt.logout()
			.then(afterRevokeToken)
			.catch(afterRevokeToken);
	},
	getAuthorizationHeader(){
		return `Bearer ${localStorage.get(TOKEN)}`
	},
}