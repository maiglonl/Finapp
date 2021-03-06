import jwtToken from '../services/jwtToken';
import localStorage from '../services/localStorage';
import {User} from '../services/resources';

const USER = 'user';

const state = {
	user: localStorage.getObject(USER) || {name: ''},
	check: jwtToken.token != null
};

const mutations = {
	setUser(state, user){
		state.user = user;
		if(user !== null){
			localStorage.setObject(USER, user);
		}else{
			localStorage.remove(USER);
		}
	},
	autenticated(state){
		state.check = true;
	},
	unautenticated(state){
		state.check = false;
	}
};

const actions = {
	login(context, {email, password}){
		return jwtToken.accessToken(email, password).then((response) => {
			context.commit('autenticated');
			context.dispatch('getUser');
			return response
		});
	},
	getUser(context){
		return User.get().then((response) => {
			context.commit('setUser', response.data);
		});
	},
	clearAuth(context){
		context.commit('unautenticated');
		context.commit('setUser', null);
	},
	logout(context){
		let afterLogout = (response) => {
			context.dispatch('clearAuth');
			return response;
		}

		return jwtToken.revokeToken()
			.then(afterLogout)
			.catch(afterLogout);
	}
};

const module = {
	state, mutations, actions
}

export default module;