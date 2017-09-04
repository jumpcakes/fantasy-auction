<template>
	<modal>
		<div class="modal-header">You Are on the Clock Choose A Player</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-2">
					<filter-bar></filter-bar>
				</div>
				<div class="col-md-6">
					<label>Position</label>
					<select v-model="positionFilter" @change="filterByPosition">
						<option value="1">All</option>
						<option value="QB">QB</option>
						<option value="RB">RB</option>
						<option value="WR">WR</option>
						<option value="TE">TE</option>
						<option value="DST">Defense</option>
					</select>
				</div>
			</div>
    		<vuetable ref="vuetable"
				api-url="/players"
			   	:fields="fields"
	            data-path="data"
	          	:css="css"
	          	:append-params="moreParams"
	          	pagination-path=""
	          	:per-page="5"
	          	@vuetable:pagination-data="onPaginationData"
			></vuetable>
			<vuetable-pagination 
				ref="pagination"
				:css="css.pagination"
				@vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
            <div class="row">
	          <div class="col-md-6">
	            <vuetable-pagination-info ref="paginationInfo"
	            ></vuetable-pagination-info>
	          </div>
	          <div class="col-md-6">
	            <vuetable-pagination ref="pagination"
	              :css="css.pagination"
	              @vuetable-pagination:change-page="onChangePage"
	            ></vuetable-pagination>
	          </div>
	        </div>
		</div>
	</modal>
</template>

 <script>

 	import Vuetable from 'vuetable-2/src/components/Vuetable'
 	Vue.component('modal', require('./Modal.vue'));
 	Vue.component('choose-player-actions', require('./ChoosePlayerActions.vue'));
 	Vue.component('filter-bar', require('./FilterBar.vue'));
 	import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
  	import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
	
	export default {
		components: {
			Vuetable,
			VuetablePagination,
			VuetablePaginationInfo
		},

	 	methods: {
	 		filterByPosition() {
	 			this.moreParams = {
		          position: this.positionFilter
		        }
		        Vue.nextTick( () => this.$refs.vuetable.refresh() )
	 		},

	 		onPaginationData (paginationData) {
		        this.$refs.pagination.setPaginationData(paginationData)
		        this.$refs.paginationInfo.setPaginationData(paginationData)
		    },
		    
		    onChangePage (page) {
		        this.$refs.vuetable.changePage(page)
		    },

	  	},

	  	created() {
	  		Event.$on('close', function() {
	        	this.$emit('close');
	      	}.bind(this));
	  	},

	  	data: function() {
	  		return {
	  			positionFilter: 1,
	  			moreParams: null,
	  			fields: [
		          {
		            name: '__sequence',   // <----
		            title: '#',
		            titleClass: 'center aligned',
		            dataClass: 'aligned'
		          },
		          {
		            name: 'name',
		            title: 'Name',
		          },
		          {
		            name: 'position',
		            title: 'Position',
		          },
		          {
		            name: 'rank',
		            title: 'Overall Rank',
		          },
		          {
		            name: '__component:choose-player-actions',
		            title: 'Select Player',
		            titleClass: 'text-center',dataClass: 'text-center'
		          },
		        ],
		        css: {
		          tableClass: 'table table-striped table-hovered',
		          loadingClass: 'loading',
		          ascendingIcon: 'glyphicon glyphicon-chevron-up',
		          descendingIcon: 'glyphicon glyphicon-chevron-down',
		          handleIcon: 'glyphicon glyphicon-menu-hamburger',
		          pagination: {
		            infoClass: 'pull-left',
		            wrapperClass: 'vuetable-pagination pull-right',
		            activeClass: 'btn-primary',
		            disabledClass: 'disabled',
		            pageClass: 'btn btn-border',
		            linkClass: 'btn btn-border',
		            icons: {
		              first: '',
		              prev: 'fa fa-angle-left',
		              next: 'fa fa-angle-right',
		              last: '',
		            },
		          }
		        }
	  		}
	  	},
	  	events: {
	      'filter-set' (filterText) {
	        this.moreParams = {
	          filter: filterText,
	        }
	        Vue.nextTick( () => this.$refs.vuetable.refresh() )
	      },
	    }

	}
 </script>

 <style type="text/css">
 	.modal-header {
	    font-size: 21px;
	    color: #000;
	}
 </style>