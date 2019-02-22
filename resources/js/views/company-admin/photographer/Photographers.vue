<template>
	<div>
		<v-container fluid grid-list-xl pt-0>
			<v-layout row wrap>
				<v-flex xs12 md12 lg12 sm12 class="col-height-auto">
					<div>
						<div class=" custom-profile-body">
							<v-layout row wrap>
								<v-flex xs12 md5 lg4 class="col-height-auto">
									<v-list two-line>
									  
										<app-card
											customClasses="custom-flex-appcard"
										>
											<v-text-field
						            label="Solo"	
						            placeholder="Name Photographer"
						            solo
						            v-model="search"
						            @keyup="searchPhotographer()"
						          ></v-text-field>

						          <v-btn icon @click="searchPhotographer()">
						            <v-icon>search</v-icon>
						          </v-btn>

										</app-card>
						          <v-divider></v-divider>
									</v-list>

									<vue-perfect-scrollbar :settings="settings" style="height:640px;">
										<v-list two-line>
						          <template v-for="(item, index) in items">
						          	<div class="hover-photographer">
						            <v-list-tile :key="index" avatar ripple @click="showDetail(item)" :class="item.id == photographerId && checkDetail ? 'active-list-title' : ''">
						              	<v-list-tile-avatar>
							                <img src="/static/img/post-2.png">
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
									<app-card	
									>
									<v-layout row wrap justify-space-between align-center>
										<div>
											<v-btn fab dark small color="cyan" v-show="checkDetail">
								      	<v-icon dark @click="showFormEdit(itemDetail)">edit</v-icon>
								    	</v-btn>

									    <v-btn fab dark small color="error" v-show="checkDetail">
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
										<!-- <v-flex xs12>
											<div style="height: 40px !important">
												<v-btn fab dark small color="cyan" v-show="checkDetail">
									      	<v-icon dark @click="showFormEdit(itemDetail)">edit</v-icon>
									    	</v-btn>

										    <v-btn fab dark small color="error" v-show="checkDetail">
										      <v-icon dark @click="showDialog(itemDetail.id)">delete</v-icon>
										    </v-btn>
											</div>
										</v-flex>
										<v-flex xs12 md6 class="btn-add-photographer">
											<v-btn
									      color="indigo"
									      class="white--text"
									      @click="showFromAdd()"
									    >
									      Add New
									    </v-btn>
										</v-flex> -->
									</v-layout>

										<div class="media-body" v-show="checkDetail" style="margin-top:20px">
											<div class="media media-full">
												<div class="media-image">
													<!-- <v-img src="/static/img/post-2.png" class="img-responsive mr-4" alt="post image" width="300" height="120" /> -->
													<v-img
									          src="/static/img/post-2.png"
									          lazy-src="/static/img/post-2.png"
									          width="300"
									          class="img-responsive mr-4"
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
	</div>
			
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import PhotographerDetail from './PhotographerDetail'
import PhotographerAdd from './PhotographerAdd'
import PhotographerEdit from './PhotographerEdit'

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
      photographerId: ''
    }
		},
	created() {
		this.fetchData()
	},
	mounted() {
		this.$root.$on('reloadTablePhotographer', res => {
			this.fetchData()
		})
	},
	methods: {
		fetchData() {
			get(config.API_URL+'photographers?companyId='+this.company.company_id)
			.then(response => {
				if(response && response.data.success) {
					this.items = response.data.data
				}
			})
		},
		deleteItem() {
			del(config.API_URL+'photographer/'+this.itemIdToDelete+'?userId='+this.company.id)
			.then((res) => {
        if(res.data && res.data.success){
          this.fetchData()
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
        console.log(e)
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
  		if(this.checkDetail && this.photographerId == item.id) {
  			this.checkDetail = false
  		}else {
  			this.checkDetail = true
	  		this.itemDetail = item
	  		this.photographerId = item.id
  		}
  	},
  	searchPhotographer()
  	{
  		get(config.API_URL+'photographers?companyId='+this.company.company_id+'&search='+this.search)
  		.then(response => {
  			if(response && response.data.success) {
  				this.items = response.data.data
  			}
  		})
  	}

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