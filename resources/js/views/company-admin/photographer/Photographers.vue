<template>
		<v-container fluid grid-list-xl pt-3>
			<v-layout row wrap>
				<v-flex xs12 md12 lg12 sm12 class="col-height-auto">
					<div>
						<div class=" custom-profile-body">
							<v-layout row wrap>
								<v-flex xs12 md5 lg4 class="col-height-auto">
									<v-list two-line>
										<app-card customClasses="custom-flex-appcard">
											<v-text-field
						            label="Solo"
						            placeholder="Search Photographer"
						            solo
						            v-model="search"
						            @keyup="searchPhotographer()"
												append-icon="search"
						          ></v-text-field>

						          <!-- <v-btn icon @click="searchPhotographer()">
						            <v-icon>search</v-icon>
						          </v-btn> -->
										</app-card>
						       	<v-divider></v-divider>
									</v-list>

									<vue-perfect-scrollbar :settings="settings" style="height:640px;">
										<v-list two-line>
						          <template v-for="(item, index) in items">
						          	<div class="hover-photographer">
						            	<v-list-tile
											:key="index"
											avatar
											ripple
											@click="showDetail(item)"
											:class="item.id == photographerId && checkDetail ? 'active-list-title' : ''"
											>
												<v-list-tile-avatar v-if="item.avatar == undefined || item.avatar == null || item.avatar == '' ">
							             			<img src="static/avatars/noavatar.jpg" >
							              		</v-list-tile-avatar>

							              		<v-list-tile-avatar v-else>
													<img :src="item.avatar">
							              		</v-list-tile-avatar>

							              <v-list-tile-content>
						                	<v-list-tile-title>{{ item.name }}</v-list-tile-title>
						              	</v-list-tile-content>

						              	<v-list-tile-action v-if="item.id == photographerId && checkDetail">
															<v-btn icon>
							                	<v-icon color="indigo darken-1">star</v-icon>
							              	</v-btn>
						              	</v-list-tile-action>

							              <v-list-tile-action v-else>
															<v-btn icon>
							                	<v-icon color="grey lighten-1">star_border</v-icon>
							              	</v-btn>
							              </v-list-tile-action>

						            	</v-list-tile>
						            	<v-divider v-if="index + 1 < items.length" :key="`divider-${index}`" class="m-0"></v-divider>
						          	</div>
						          </template>
						        </v-list>
					      	</vue-perfect-scrollbar>

								</v-flex>

								<v-flex xs12 md7 lg8>
									<app-card>
										<v-layout row wrap justify-space-between align-center>
											<div>
												<v-btn fab dark small color="cyan" v-if="checkDetail">
									      	<v-icon dark @click="showFormEdit(itemDetail)">edit</v-icon>
									    	</v-btn>

										    <v-btn fab dark small color="error" v-if="checkDetail">
										      <v-icon dark @click="showDialog(itemDetail.id)">delete</v-icon>
										    </v-btn>
											</div>
											<v-spacer></v-spacer>
											<div>
												<v-btn
										      color="indigo"
										      class="white--text"
										      @click="showFromAdd()"
										    >
										      Add New
										    </v-btn>
											</div>
										</v-layout>

										<div class="media-body" v-if="checkDetail" style="margin-top:20px">
											<div class="media media-full">

												<div class="media-image" v-if="itemDetail.avatar == null || itemDetail.avatar == ''">
													
													<v-img
											          src="/static/avatars/noavatar.jpg"
											          width="300"
											          height="380"
											          class="img-responsive mr-4"
											          style="margin: 0 auto !important;"
											        ></v-img>
														<span>{{itemDetail.name}}</span>
												</div>

												<div class="media-image" v-else>
													
													<v-img
											          :src="itemDetail.avatar"
											          width="300"
											          height="380"
											          class="img-responsive mr-4"
											          style="margin: 0 auto !important;"
											        ></v-img>
														<span>{{itemDetail.name}}</span>
												</div>

												
												<div class="media-body">
												  <v-list class="heigth-list-title">
														<template>

															<v-list-tile>
																<v-list-tile-content>
											          	<v-list-tile-title class="content-flex">
												          	<span class="font-weight-bold item-title">Address:</span>
												          	<span class="max-value">{{itemDetail.address}}</span>
										        			</v-list-tile-title>
																</v-list-tile-content>
															</v-list-tile>

															<v-list-tile>
																<v-list-tile-content>
											          	<v-list-tile-title class="content-flex">
												          	<span class="font-weight-bold item-title">Phone number:</span>
												          	<span class="max-value">{{itemDetail.phone_number}}</span>
										        			</v-list-tile-title>
																</v-list-tile-content>
															</v-list-tile>

															<v-list-tile>
																<v-list-tile-content>
											          	<v-list-tile-title class="content-flex">
												          	<span class="font-weight-bold item-title">Email:</span>
												          	<span class="max-value">{{itemDetail.email}}</span>
										        			</v-list-tile-title>
																</v-list-tile-content>
															</v-list-tile>

															<v-list-tile>
																<v-list-tile-content>
											          	<v-list-tile-title class="content-flex">
												          	<span class="font-weight-bold item-title">Branch:</span>
												          	<span class="max-value" v-if="itemDetail.branch">{{itemDetail.branch.name}}</span>
										        			</v-list-tile-title>
																</v-list-tile-content>
															</v-list-tile>

															<v-list-tile>
																<v-list-tile-content>
											          	<v-list-tile-title class="content-flex">
												          	<span class="font-weight-bold item-title">Status:</span>
												          	<span class="max-value">{{itemDetail.status ? 'Active' : 'Inactive'}}</span>
										        			</v-list-tile-title>
																</v-list-tile-content>
															</v-list-tile>

															<v-list-tile class="heigth-list-title-style">
																<v-list-tile-content>
											          	<v-list-tile-title class="content-flex">
												          	<span class="font-weight-bold item-title">ID Copy:</span>
												          	<img :src="itemDetail.identification_card" width="320px" height="170px" slot="activator">
										        			</v-list-tile-title>
																</v-list-tile-content>
															</v-list-tile>

														</template>
											    </v-list>
												</div>
											</div>
										</div>
										<photographer-add></photographer-add>
										<photographer-edit></photographer-edit>

										<v-dialog v-model="dialog" persistent max-width="450">
								      <v-card>
								        <v-card-title class="headline font-weight-bold grey lighten-3">
								          <v-icon large color="warning" class="mr-2">
								            warning
								          </v-icon>
								          Do you want delete this item ?
								        </v-card-title>
								        <v-divider class="mt-0"></v-divider>
								        <v-card-actions>
								          <v-spacer></v-spacer>
								          <v-btn color="secondary" outline small @click="dialog = false">Disagree</v-btn>
								          <v-btn color="warning" outline small @click="deleteItem">Agree</v-btn>
								        </v-card-actions>
								      </v-card>
							    	</v-dialog>
									</app-card>
								</v-flex>
							</v-layout>
						</div>
					</div>
				</v-flex>
			</v-layout>
		</v-container>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import PhotographerDetail from './PhotographerDetail'
import PhotographerAdd from './PhotographerAdd'
import PhotographerEdit from './PhotographerEdit'
import Lodash from 'lodash'

export default {

  name: 'Photographer',
  components: {
  	PhotographerDetail,PhotographerAdd,PhotographerEdit
  },

	data () {
    return {
    	headers: [
				{ text: 'ID', value: 'id'},
				{ text: 'Branch Name', value: 'branch.name' },
				{ text: 'Name', value: 'name'},
				{ text: 'Phone', value: 'phone_number' },
				{ text: 'Address', value: 'address' },
				{ text: 'Added Date', value: 'created_at' },
				{ text: 'Status', value: 'status' , sortable: false},
		    { text: 'Action', sortable: false },
			],
			items: [],
			search:'',
			pagination: {
			  	rowsPerPage: 25
	    },
	    rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
	    company: JSON.parse(localStorage.getItem('user')),
	    dialog: false,
	    activeInfo: true,
	    itemIdToDelete: '',
	    loading: false,
	    checkDetail: false,
	    itemDetail: [],
	    settings: {
        	maxScrollbarLength: 160
      	},
	    photographerId: 0,
	    activeItem: ''
    }
		},
	created() {
		this.fetchData(this.activeItem)
	},
	mounted() {
		this.$root.$on('reloadTablePhotographer', res => {
			this.fetchData(res.data.id)
		})

		this.$root.$on('reloadTablePhotographerAdd', res => {
			this.fetchData(this.activeItem)
		})
	},
	methods: {
		fetchData(activeItem) {
			get(config.API_URL+'photographers?companyId='+this.company.company_id)
			.then(response => {
				if(response && response.data.success) {
					this.items = response.data.data
					if(activeItem == '') {
						this.photographerId = this.items[0].id
					} else {
						this.photographerId = activeItem
					}
					this.checkDetail = true
					this.detailItem(this.photographerId)
				}
			})
		},

		deleteItem() {
			del(config.API_URL+'photographer/'+this.itemIdToDelete+'?userId='+this.company.id)
			.then((res) => {
		        if(res.data && res.data.success){
		          	this.fetchData(this.activeItem)
		          	this.dialog = false
		          	this.$notify({
			          title: 'Success',
			          message: 'Delete Item Successfully.',
			          type: 'success',
			          duration: 2000,
			        })
			        this.checkDetail = false
		    	}
      		})
		    .catch((e) =>{
		        console.log(e.response)
		    })
		},

		detailItem(photographerId) {
			get(config.API_URL+'photographer/detail/'+photographerId)
			.then((res) => {
				if(res.data && res.data.success) {
					this.itemDetail = res.data.data
				}
			})
			.catch((e) =>{
	        	console.log(e.response)
	      })
		},

		showInfo(item) {
			this.$root.$emit('showInfoPhototographer', {showNavigation: true,data: item})
		},

		showDialog(item) {
			this.dialog = true
			this.itemIdToDelete = item
		},

		showFromAdd() {
			this.$root.$emit('showPhotographerAdd', {showNavigation:true})
		},

		showFormEdit(item) {
			this.$root.$emit('showFormEditPhotgrapher', {showNavigation: true, data: item})
		},

		changeSort (column) {
		    var columnsNoSearch = ['actions']
	    	if (columnsNoSearch.indexOf(column) > -1) {
	        	return
	    	}
		    this.loading = true
	    	if (this.pagination.sortBy === column) {
	        	this.pagination.descending = !this.pagination.descending
	    	} else {
	        	this.pagination.sortBy = column
	        	this.pagination.descending = false
	      	}
		    this.loading = false
  		},
	  	showDetail(item)
	  	{
	  		
  			this.checkDetail = true
	  		this.itemDetail = item
	  		this.photographerId = item.id

	  	},
	  	searchPhotographer : _.debounce(
				function() {
					get(config.API_URL + 'photographers?companyId=' + this.company.company_id + '&search=' + this.search)
					.then(response => {
						if(response && response.data.success) {
							this.items = response.data.data
						}
					})
					.catch(err => {
						if (err.response && err.response.data && !err.response.data.success) {
							this.$message({
								title: "WARNING!",
								message: err.response.data.message,
								type: 'warning',
								duration: 2000
							})
						}
					})
		  	}, 1000)
		}
};
</script>

<style lang="scss" scoped>
	.photographer-table{
		margin-top:30px;
	}
	.add-btn{
		right:0px;
		position: absolute;
		top: 8px;
	}
	.hover-icon{
    &:hover{
      color: blue !important;
    }
	}
	.action-width-photographer{
		min-width: 113px;
	}
	.content-flex{
	height: auto !important;
	white-space: inherit !important;
	align-items: inherit !important;
	}
.max-value{
	max-width: 63%;
	flex: 0 0 63%;
}
</style>
