import ptBR from 'vee-validate/dist/locale/pt_BR';
import VeeValidate, { Validator } from 'vee-validate';

// Localize takes the locale object as the second argument (optional) and merges it.
Validator.localize('pt-BR', ptBR);

// Install the Plugin and set the locale.
Vue.use(VeeValidate, {
  locale: 'pt-BR'
});
