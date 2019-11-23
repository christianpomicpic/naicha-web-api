<template>
	<div id="responsive-table">
		<div class="row m-0">
			<div class="col-lg-5 px-0">
				<div class="input-group hl-success input-group-sm border">
					<div class="input-group-prepend">
						<span class="input-group-text bg-transparent border-0" id="basic-addon1">
							<i class="fas fa-fw fa-lg fa-search"></i>
						</span>
					</div>
					<input type="text" class="form-control border-0" v-model="searchInput" placeholder="Search Here..." required=""
					v-on:keyup="searchResults()">
				</div>
			</div>
			<div class="col-12"></div>
			<div class="col-12 py-3"></div> 
		</div>
		<div class="row m-0 border-left border-top">
			<div class="col-1 border-bottom py-2 px-2 ">
				<slot name="checkbox-slot" v-if="canselect">
					<div class="custom-control custom-checkbox">
      					<input type="checkbox" class="custom-control-input" id="customCheck" v-model="selectAll" @click="select">
    					<label class="custom-control-label" for="customCheck"></label>
    				</div>
				</slot>
			</div>
			<div v-for="column in columns" :class="column.class + ' border-bottom py-2 px-2'">
				<small>
					<strong>
						{{ column.label }} 
						<a href="javascript:void(0)" v-if="column.filterable" class="sort-anchor" v-on:click="sortResults(column.name)">
							<i class="fas fa-fw fa-sort"></i>
						</a>
					</strong>
				</small>
			</div>
			<div class="col-1 border-bottom py-2 px-2 text-center border-right">
				<slot name="action-slot">
					
				</slot>
			</div>
		</div>
		<div :id="listname+'-searchInputNullResults'" v-if="!searchInput">
			<div v-if="tabledata.length > 0">
				<div v-if="newTableData.length > 0">
					<div v-for="(data, key) in newTableData" class="row m-0 border-left border-right">
						<div class="col-1 border-bottom py-2 px-2">
							<slot name="checkbox-record-slot" :record="data.props" v-if="canselect">
								<label class="form-checkbox mb-0">
									<div class="custom-control custom-checkbox mb-3">
				      					<input type="checkbox" class="custom-control-input" :id="data.id" :value="data" v-model="selected">
				    					<label class="custom-control-label" :for="data.id"></label>
				    				</div>
	  							</label>
							</slot>
						</div>
						<div v-for="(keyData, key) in data" v-if="displayData(key)" :class="setDataRowClass(key) + ' border-bottom py-2 px-2'">
							<slot :name="key" :record="data.props">
								<small>{{ keyData }}</small>
							</slot>
						</div>
						<div class="col-1 border-bottom py-2 px-2 action-btn-parent-wrapper">
							<div class="text-right action-btn-wrapper">
								<slot name="action-record-slot" :record="data.props">
									<a :href="'#collapse-'+data.id" class="text-dark" data-toggle="collapse" aria-expanded="true">
										<i class="fas fa-fw fa-ellipsis-v font-weight-bold mt-1"></i>
									</a>
								</slot>
								<slot name="action-delete-slot" :record="{index:key,id:data.id,data: data}">
									
								</slot>
							</div>
						</div>
						<div class="col-12 collapse px-0 border-bottom" style="background-color: #F9FCFC !important;" :id="'collapse-'+data.id" aria-labelledby="headingOne" :data-parent="'#'+listname+'-searchInputNullResults'">
							<slot name="datapreview" :record="data.props"></slot>
						</div>
					</div>
				</div>
			</div>
			<div class="row m-0" v-else>
				<div class="col-12 py-5 text-center border border-top-0">
					<h3>No Data To Display...</h3>
				</div>
			</div>
		</div>
		<div :id="listname+'-searchInputNotNullResults'" v-else>
			<div v-if="searchedDataList.length > 0">
				<div v-for="data in searchedDataList" class="row m-0 border-left border-right">
					<div class="col-1 border-bottom py-2 px-2">
						<slot name="checkbox-record-slot" v-if="canselect">
						</slot>
					</div>
					<div v-for="(keyData, key) in data" v-if="displayData(key)" :class="setDataRowClass(key) + ' border-bottom py-2 px-2'">
						<slot :name="key" :record="data.props">
							<small>{{ keyData }}</small>
						</slot>
					</div>
					<div class="col-1 border-bottom py-2 px-2 action-btn-parent-wrapper">
						<slot name="action-record-slot" :record="data.props">
							<div class="text-right action-btn-wrapper">
								<a :href="'#collapse-'+data.id" class="text-dark" data-toggle="collapse" aria-expanded="true">
									<i class="fas fa-fw fa-ellipsis-v font-weight-bold mt-1"></i>
								</a>
							</div>
						</slot>
					</div>

					<div class="col-12 collapse px-0" style="background-color: #F9FCFC !important;" :id="'collapse-'+data.id" aria-labelledby="headingOne" :data-parent="'#'+listname+'-searchInputNotNullResults'">
						<slot name="datapreview" :record="data.props"></slot>
					</div>
				</div>
			</div>

			<div class="row m-0" v-else>
				<div class="col-12 py-5 text-center border border-top-0">
					<h3>No Data Matched...</h3>
				</div>
			</div>
		</div>
		<br>
		<div v-if="!searchInput">
			<nav aria-label="Page navigation example" style="float:right">
			  <ul class="pagination">
			    <li class="page-item"><a class="page-link" v-on:click="prev()"><small>Prev</small></a></li>
			    <li class="page-item" v-for="p in pageCount" ><a class="page-link" v-if="pageNo == p" v-on:click="page(p)"><small>{{p}}</small></a>
			    	<a class="page-link" v-else v-on:click="page(p)">{{p}}</a></li>
			    <li class="page-item"><a class="page-link" v-on:click="next()"><small>Next</small></a></li>
			  </ul>
			</nav>
			<nav aria-label="Page navigation example" >
			  <ul class="pagination">
			  	<li class="page-item"><a class="page-link" v-on:click="first()"><small>First</small></a></li>
			    <li class="page-item"><a class="page-link" v-on:click="prev()"><small>Prev</small></a></li>
			    <li class="page-item"><a class="page-link"><small>{{pageNo}}/{{pageCount}}</small></a></li>
			    <li class="page-item"><a class="page-link" v-on:click="next()"><small>Next</small></a></li>
			    <li class="page-item"><a class="page-link" v-on:click="last()"><small>Last</small></a></li>
			  </ul>
			</nav>			
        </div>
	</div>
</template>
<style lang="css">
	.sort-anchor {
		color: grey !important;
		transition: 0.3s font-size ease;
	}

	.sort-anchor:hover {
		color: grey !important;
		font-size: 16px;
		transition: 0.3s font-size ease;
	}

	@media only screen and (max-width : 460px) { 
		.action-btn-parent-wrapper {
			padding-left: 0px !important;
			padding-right: 0px !important;
		}

		.action-btn-wrapper {
			padding-left: 0px !important;
			padding-right: 0px !important;
			text-align: center !important;
		}

		.action-btn-wrapper i {
			font-size: 16px !important;
    		margin-right: 10px !important;
		}
	}
</style>
<script type="text/javascript">
	export default {
		data(){
			return {
				columnNameList: [],
				searchableColumnList: [],
				filteredColumnList: [],
				searchInput: '',
				backupSearchInput: '',
				searchedDataList: [],
				selected:[],
				selectAll: false,
				pageNo: 1,
    			pageSize: 5,
    			pageCount: 0,
    			newTableData:[]
			}
		},
		mounted(){
    		this.init();
  		},
		created(){
			for(var counter = 0; counter < this.columns.length; counter++){
				this.columnNameList.push(this.columns[counter]['name']);
				if(this.columns[counter]['searchable']){
					this.searchableColumnList.push(this.columns[counter]['name']);
				}
				if(this.columns[counter]['filterable']){
					var object = {};
					object['name'] = this.columns[counter]['name'];
					object['filtered'] = false;

					this.filteredColumnList.push(object);
				}
			}


			console.log("SEARCHABLE COLUMN LIST:");
			console.log(this.searchableColumnList);
		},
		methods: {
			select() {
				this.selected = [];
				if (!this.selectAll) {
					for (let i in this.tabledata) {
						this.selected.push(this.tabledata[i]);
					}

				}else{
					this.selectAll =true
					
				}
			},
			setDataRowClass(key){
				for(var counter = 0; counter < this.columns.length; counter++){
					if(this.columns[counter]['name'] == key){
						return this.columns[counter]['class'];
						break;
					}
				}
			},
			displayData(key){
				var result = this.columnNameList.indexOf(key);
				if(result > -1){
					return true;
				}
				else{
					return false;
				}
			},

			searchResults(){
				if(this.searchInput != this.backupSearchInput){
					this.backupSearchInput = this.searchInput;

					var resultCollection = [];
					var filtered = [];
					var filteredAll = [];
					for(var counter = 0; counter < this.searchableColumnList.length; counter++){
						filtered = this.tabledata.filter(post => {
					        return post[this.searchableColumnList[counter]].toLowerCase().includes(this.searchInput.toLowerCase());
					    });

					    for(var innerFilterCounter = 0; innerFilterCounter < filtered.length; innerFilterCounter++){
					    	filteredAll.push(filtered[innerFilterCounter]);
					    }
					}

					var idsExists = [];
					for(var filteredCounter = 0; filteredCounter < filteredAll.length; filteredCounter++){
						if(idsExists.indexOf(filteredAll[filteredCounter]['id']) < 0){
							idsExists.push(filteredAll[filteredCounter]['id']);
							resultCollection.push(filteredAll[filteredCounter]);
						}
					}

					this.searchedDataList = resultCollection;

				}
			},

			sortResults(fieldName){
				var thisFunc = this;
				for(var counter = 0; counter < thisFunc.filteredColumnList.length; counter++){
					if(thisFunc.filteredColumnList[counter]['name'] == fieldName){
						this.tabledata.sort(function(a, b){
							var stringA = a[fieldName].toLowerCase();
							var stringB = b[fieldName].toLowerCase();
							if(!thisFunc.filteredColumnList[counter]['filtered']){
								if (stringA < stringB) // sort string ascending
									return -1;
								if (stringA > stringB)
									return 1;
							}
							else {
								if (stringA > stringB) // sort string descending
									return -1;
								if (stringA < stringB)
									return 1;
								 
							}

							return 0; // default return value (no sorting)
						});


						if(thisFunc.filteredColumnList[counter]['filtered']){
							thisFunc.filteredColumnList[counter]['filtered'] = false;
						}
						else{
							thisFunc.filteredColumnList[counter]['filtered'] = true;
						}

						break;
					}
				}
			},

		   init(){ 
		      this.virtualService({
		        pageNo: this.pageNo,
		        pageSize: this.pageSize
		      });
		    },

		   count(condition){
			   	return this.tabledata.length;
    		},

    		queryFromVirtualDB(condition, startRow, endRow){
		      	  var result = [];
			      var condition = {};
			      if(!this.searchInput) var list = this.tabledata;
			      else var list = this.searchedDataList;
			      var data = this.tabledata;
			      var count = this.count(condition);
			      for(var i = startRow - 1; i < endRow; i++) {
			        if(i < count){
			          result.push(data[i]);
			        }
			    }
	      		return result;
	   		},

	   		virtualService(params){
			      
		      var result = [];
		      var condition = {};
		      var pageNo = params.pageNo;
		      var pageSize = params.pageSize;
		      var pageCount = Math.ceil(this.count(condition) / pageSize);
						
		      if (pageNo == 0) pageNo = 1;
		      if (pageNo < 0) pageNo = pageCount;
		      else if (pageNo > pageCount) pageNo = pageCount;
		      var startRow = (pageNo - 1) * pageSize + 1;
			  var endRow = startRow + pageSize - 1;
		      var data = this.queryFromVirtualDB(condition, startRow, endRow);
		      
		      //set result
		      this.pageNo = pageNo;
		      this.pageCount = pageCount;
		      this.newTableData = data;
      
    		},

    		page(pageNo) {    
		     this.virtualService({
		        pageNo: pageNo,
		        pageSize: this.pageSize
		      });
		    },

		    first() {
		        this.pageNo = 1; 
		        this.virtualService({
		          pageNo:this.pageNo,
		          pageSize:this.pageSize
		        });
		    },

		    last() {
		        this.pageNo = this.pageCount; 
		        this.virtualService({
		          pageNo:this.pageNo,
		          pageSize:this.pageSize
		        });
		    },

		    prev() {
		      if(this.pageNo > 1){ 
		        this.pageNo -= 1; 
		        this.virtualService({
		          pageNo:this.pageNo,
		          pageSize:this.pageSize
		        });
		      }
		    },

		    next() {
		      if(this.pageNo < this.pageCount) {
		        this.pageNo += 1;
		        this.virtualService({
		          pageNo:this.pageNo,
		          pageSize:this.pageSize
		        });
		      }
		    },
		},
		watch: {
			tabledata(value){
		    	this.newTableData = value;
		    	this.init();
		    }
		},
		props: ['tabledata', 'columns', 'listname', 'canselect']

	}
</script>