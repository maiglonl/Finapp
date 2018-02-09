import Pusher from 'pusher-js';
import Echo from 'laravel-echo';
import JwtToken from './services/jwtToken';


window.Echo = new Echo({
	broadcaster: 'pusher',
	key: 'b6b4d6dcf73ba1bc2ded',
	cluster: 'us2'
});

const changeJwtTokenInEcho = value => {
	window.Echo.connector.pusher.config.auth.headers['Authorization'] = JwtToken.getAuthorizationHeader();
}

JwtToken.event('updateToken', value => {
	changeJwtTokenInEcho(value);
});

changeJwtTokenInEcho(JwtToken.token);
