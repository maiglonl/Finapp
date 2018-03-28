import moment from 'moment';
import 'moment/locale/pt-br';
import numeral from 'numeral';
import 'numeral/locales/pt-br';

moment.locale('pt-br');
numeral.locale('pt-br');

Vue.filter('numberFormat', (value, isCurrency = false) => {
	let number = 0;
	if(value && value != "" && !isNaN(value)){
		number = isCurrency ? numeral(value).format('$0,0.00') : numeral(value).format('0,0.00');
	}
	return number;
});

Vue.filter('dateFormat', (value) => {
	if(value && typeof value !== undefined){
		let date = moment(value);
		return date.isValid() ? date.format('DD/MM/YYYY') : value;
	}
	return value;
});

Vue.filter('monthYear', (value) => {
	return moment(value instanceof Date ? value : `${value}-01`).format('MM/YYYY');
});
