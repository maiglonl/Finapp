
import jwtToken from './jwtToken';
import localStorage from './localStorage';
import {User} from '../services/resources';

const USER = 'user';

const afterLogin = function(response){
	this.user.check = true;
	User.get()
		.then((response) => {
			this.user.data = response.data 
		});
};

export default {
	user: {
		set data(value){
			if(!value){
				localStorage.remove(USER);
				this._data = null;
				return;
			}
			this._data = value;
			localStorage.setObject(USER, value);
		},
		get data(){
			if(!this._data){
				this._data = localStorage.getObject(USER)
			}
			return this._data;
		},
		check: jwtToken.token ? true : false
	},
	login(email, password){
		return jwtToken.accessToken(email, password).then((response) => {
			let afterLoginContext = afterLogin.bind(this);
			afterLoginContext(response);
			return response
		});
	},
	logout(){
		let afterLogout = (response) => {
			this.clearAuth();
			return response;
		}

		return jwtToken.revokeToken()
			.then(afterLogout)
			.catch(afterLogout);
	},
	clearAuth(){
		this.user.data = null;
		this.user.check = false;
	}
}