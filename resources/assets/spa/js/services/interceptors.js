import jwtToken from './jwtToken';
import auth from './auth';
import appConfig from './appConfig';

Vue.http.interceptors.push((request, next) => {
	request.headers.set('Authorization', jwtToken.getAuthorizationHeader());
	next((response) => {
		if(response.status === 401){
			return jwtToken.refreshToken()
			.then(() => {
				return Vue.http(request);
			})
			.catch(() => {
				auth.clearAuth;
				window.location.href = appConfig.login_url
			});
		}
	});
});
