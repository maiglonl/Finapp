import ptBR from 'vee-validate/dist/locale/pt_BR';
import VeeValidate, { Validator } from 'vee-validate';

// Localize takes the locale object as the second argument (optional) and merges it.
Validator.localize('pt-BR', ptBR);

Validator.extend('date', {
	messages: {
		'pt-BR': (field, args) => {
			return 'Data inválida em '+field;
		}
	},
	validate: value => {
		return moment(value).isValid();
	}
});

// Install the Plugin and set the locale.
Vue.use(VeeValidate, {
  locale: 'pt-BR'
});
