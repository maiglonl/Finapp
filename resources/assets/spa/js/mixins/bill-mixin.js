import PageTitleComponent from '../components/pageTitle.vue';
import ModalComponent from '../../../_default/components/Modal.vue';
import SelectMaterialComponent from '../../../_default/components/selectMaterial.vue';
import store from '../store/store';
import Bill from '../models/bill';

export default {
	components: {
		'page-title': PageTitleComponent,
		'modal': ModalComponent,
		'select-material': SelectMaterialComponent,
	},
	props: {
		index: {
			type: Number,
			required: false,
			'default': -1
		},
		modalOptions: {
			type: Object,
			required: true
		}
	},
	data(){
		return {
			bill: new Bill()
		};
	},
	computed: {
		bankAccounts(){
			return store.state.bankAccount.lists;
		},
		categoriesFormatted(){
			return store.getters[`${this.categoryNamespace()}/categoriesFormatted`];
		},
		cpOptions(){
			return{
				data: this.categoriesFormatted,
				templateResult(category){
					let margin = '&nbsp'.repeat(category.level*5);
					let text = category.hasChildren ? `<strong>${category.text}</strong>` : category.text;
					return `${margin}${text}`;
				},
				escapeMarkup(m){ return m; }
			}
		},
	},
	watch: {
		bankAccounts(bankAccounts){
			if(bankAccounts.length > 0){
				this.initAutocomplete();
			}
		}
	},
	methods: {
		validateCategory(){
			this.$validator.validate('category_id', this.bill.category_id).then((result)=>{
				let valid = result;
				let parent = $(`#${this.formId()}`).find('[name="category_id"]').parent();
				let label = parent.find('label');
				let spanSelect2 = parent.find('.select2-selection.select2-selection--single');
				if(valid){
					label.removeClass('label-error');
					spanSelect2.removeClass('select2-invalid');
				}else{
					label.removeClass('label-error').addClass('label-error');
					spanSelect2.removeClass('select2-invalid').addClass('select2-invalid');
				}
			});
		},
		validateBankAccount(){
			this.$validator.validate('bank_account_id', this.bill.bank_account_id);
		},
		initSelect2(){
			let select = $(`#${this.formId()}`).find('[name="category_id"]');
			let self = this;
			select.on('select2:close', () => {
				// TODO: Corrigir execução do evento
			});
		},
		blurBankAccount($event){
			let el = $($event.target);
			let text = this.bill.bankAccountText;
			if(el.val() != text){
				el.val(text);
			}
			this.validateBankAccount();
		},
		bankAccountHiddenId(){
			return `bank-account-hidden-${this._uid}`;
		},
		formId(){
			return `form-bill-${this._uid}`;
		},
		repeatId(){
			return `repeat-bill-${this._uid}`;
		},
		doneId(){
			return `done-${this._uid}`;
		},
		bankAccountTextId(){
			return `bank-account-text-${this._uid}`;
		},
		bankAccountDropdownId(){
			return `bank-account-dropdown-${this._uid}`;
		},
		initAutocomplete(){
			let self = this;
			$(`#${this.bankAccountTextId()}`).materialize_autocomplete({
				limit: 10,
				multiple: { enabled: false },
				hidden: { el: `#${this.bankAccountHiddenId()}` },
				dropdown: { el: `#${this.bankAccountDropdownId()}` },
				getData(value, callback){
					let mapBankAccounts = store.getters['bankAccount/mapBankAccounts'];
					let bankAccounts = mapBankAccounts(value);
					callback(value, bankAccounts);
				},
				onSelect(item){
					self.bill.bank_account_id = item.id;
					self.bill.bankAccountText = item.text;
					self.validateBankAccount();
				}
			});
			$(`#${this.bankAccountTextId()}`).parent().find('label').insertAfter(`#${this.bankAccountTextId()}`);
		},
		submit(){
			this.validateCategory();
			this.$validator.validateAll().then(success => {
				if(success){
					if(this.bill.id !== 0) {
						store.dispatch(`${this.namespace()}/edit`, {
							bill: this.bill,
							index: this.index
						}).then(() => {
							this.successSave('Conta atualizada com sucesso!');
						});
					} else {
						store.dispatch(`${this.namespace()}/save`, this.bill).then(() => {
							this.successSave('Conta criada com sucesso!');
						});
					}
				}
			})
			
		},
		successSave(message){
			$(`#${this.modalOptions.id}`).modal('close');
			Materialize.toast(message, 2000);
			this.resetScope();
		},
		resetScope(){
			this.errors.clear();
			this.$validator.clean();
			this.bill.init();
 		},
		changeCategoryId(newId){
			let newVal = newId !== 0 ? newId : null;
			this.bill.category_id = newId;
			this.validateCategory();
		}
	}
}