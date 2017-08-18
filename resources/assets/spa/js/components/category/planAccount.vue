<template>
	<div class="container">
		<div class="row">
			<page-title>
				<h5>Plano de Contas</h5>
			</page-title>
			<div class="card-panel z-depth-5">
				<h5>Categorias de Receitas</h5>
				<category-revenue v-bind:ref="revenue"></category-revenue>
				<h5>Categorias de Despesas</h5>
				<category-expense v-bind:ref="expense"></category-expense>
			</div>
			<div class="fixed-action-btn horizontal">
				<a class="btn-floating btn-large">
					<i class="larve material-icons">add</i>
				</a>
				<ul>
					<li>
						<a class="btn-floating green" href="#" @click.prevent="newRevenue" title="Nova categoria de receita">
							<i class="material-icons">attach_money</i>
						</a>
					</li>
					<li>
						<a class="btn-floating red" href="#" @click.prevent="newExpense" title="Nova categoria de despesa">
							<i class="material-icons">money_off</i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import PageTitleComponent from '../pageTitle.vue';
	import CategoryRevenue from './categoryRevenue.vue';
	import CategoryExpense from './categoryExpense.vue';

	export default {
		components: {
			'page-title': PageTitleComponent,
			'category-revenue': CategoryRevenue,
			'category-expense': CategoryExpense,
		},
		methods: {
			newRevenue(){
				EventHub.$emit('categoryRevenueNew', null);
			},
			newExpense(){
				EventHub.$emit('categoryExpanseNew', null);
			}
		}
	}
</script>