import jwtToken from './jwtToken';
import store from '../store/store';
import appConfig from './appConfig';

let logout = ()=>{
	store.dispatch('clearAuth');
	window.location.href = appConfig.login_url
}

Vue.http.interceptors.push((request, next) => {
	request.headers.set('Authorization', jwtToken.getAuthorizationHeader());
	next((response) => {
		switch(response.status){
			case 401:
				return jwtToken.refreshToken()
					.then(() => {
						return Vue.http(request);
					})
					.catch(() => {
						logout();
					});
				break;
			default:
				if(response.data && response.data.hasOwnProperty('error') && response.data.error.includes("subscription")){
					logout();
				}
				break;
		}
	});
});

