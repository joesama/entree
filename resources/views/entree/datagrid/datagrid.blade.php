    <script type="text/x-template" id="grid-template">
      <table  id="datagrid" class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th class="text-center" width="20px">#</th>
            <th v-for="key in columns"
              @click="sortBy(key.field)"
              :class="{ active: sortKey == key.field }">
              @{{ key.title | capitalize }}
              <span class="arrow" :class="sortOrders[key.field] > 0 ? 'asc' : 'dsc'">
              </span>
            </th>
            <th v-if="actions" min-width="50px" max-width="150px"  class="text-center">{{ trans('threef/entree::datagrid.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="filteredData.length < 1">
            <td :colspan="columns.length + 2"><p><center>{{ trans('threef/entree::datagrid.empty') }}</center></p></td>
          </tr>
          <tr v-for="(entry, index) in filteredData">
            <td class="text-center" style="background-color: #f9f9f9">@{{ runner + (index + 1 ) }}</td>
            <td v-for="key in columns" v-bind:class="[ key.style ? key.style : '']">
              @{{ checkDisplay(entry,key) }}
            </td>
            <td v-if="actions" class="text-center" style="background-color: #f9f9f9">
              <div class="btn-group" v-if="(actions.length > 1) && !simple">
                <button type="button" class="btn btn-xs  btn-default">{{ trans('threef/entree::datagrid.actions') }} </button>
                <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li v-for="btn in actions">
                  <a :href="uriaction(btn.url,entry[btn.key])">
                  <i v-bind:class="[ btn.icons ? 'fa ' + btn.icons : 'fa fa-pencil-square-o']" aria-hidden="true"></i>&nbsp;@{{ btn.action }} @{{ btn.delete }}
                  </a>
                  </li>
                </ul>
              </div>

              <a v-if="(actions.length < 2) && !simple" :href="uriaction(btn.url,entry[btn.key])" v-for="btn in actions" class="btn btn-xs btn-actions">
              <i v-bind:class="[ btn.icons ? 'fa ' + btn.icons : 'fa fa-pencil-square-o']" aria-hidden="true"></i>&nbsp;
              @{{ btn.action }}
              </a>
              <div  v-if="simple" class="btn-group btn-group-xs" role="group" aria-label="...">
              <a :href="uriaction(btn.url,entry[btn.key])" :title="btn.action || btn.delete" v-for="btn in actions" v-bind:class="[ btn.delete ? 'btn btn-xs btn-danger' : 'btn btn-xs btn-default']">
              <i v-bind:class="[ btn.icons ? 'fa ' + btn.icons : 'fa fa-pencil-square-o']" aria-hidden="true"></i>
              </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      
    </script>


<!-- demo root element -->
  <div class="row">
    <div class="col-md-12" id="griddata">
      <div class="row">
        <div class="col-md-12">
          <form class="form" id="search">
            <div class="row">
              <div class="col-sm-6">
                <div class="input-group">
                  <input type="text" class="form-control col-sm-8 input-sm" name="query" v-model="searchQuery" placeholder="{{ trans('threef/entree::datagrid.search') }}">
                  <span class="input-group-btn">
                    <button class="btn btn-sm btn-primary" type="button" @click.prevent="fetchItems(1)">
                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                    {{ trans('threef/entree::datagrid.search') }}
                    </button>
                  </span>
                </div><!-- /input-group -->
              </div>
              <div class="col-sm-2 col-sm-offset-4 text-right" v-if="gridNew">
                <a class="btn btn-sm btn-primary" :href="gridNew" v-if="gridNewDesc">
                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                @{{ gridNewDesc }}
                </a>
                <a class="btn btn-sm btn-primary" :href="gridNew" v-else >
                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                {{ trans('threef/entree::datagrid.buttons.add') }}
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="row">
          <div class="col-md-12">
            <demo-grid
              :data="gridData"
              :actions = "gridActions"
              :simple = "gridActionsSimple"
              :columns="gridColumns"
              :current_page="pagination.current_page"
              :per_page="pagination.per_page"
              :filter-key="searchQuery">
            </demo-grid>
          </div>
      </div>
      <div class="row">
        <div class="col-md-2 text-left">
        <ul class="pagination pagination-sm">
          <li>
           <small>
            <strong>{{ trans('threef/entree::datagrid.total') }}</strong>
            &nbsp;:&nbsp;@{{ pagination.total }}
            </small>
          </li>
        </ul>
        </div>
        <div class="col-md-5 col-md-offset-4 text-right">
        <ul class="pagination pagination-sm">
            <li v-if="pagination.current_page > 1">
                <a href="#" aria-label="Previous"
                   @click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="page in pagesNumber"
                v-bind:class="[ page == isActived ? 'active' : '']">
                <a href="#"
                   @click.prevent="changePage(page)">@{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a href="#" aria-label="Next"
                   @click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
        </div>
        <div class="col-md-1 text-right">
          <div class="btn-group" role="group" aria-label="...">
            <a  class="btn btn-sm btn-default">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
            </a>
            <a class="btn btn-sm btn-default">
            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        
      </div>
    </div>
  </div>

@push('datagrid.jscript')
<script type="text/javascript">
// Vue.config.performance = true;
// Vue.config.debug = true;
Vue.config.devtools = false;

// register the grid component
Vue.component('demo-grid', {
  template: '#grid-template',
  replace: true,
  props: {
    data: Array,
    columns: Array,
    actions: Array,
    simple: Boolean,
    current_page: String,
    per_page: String,
    filterKey: String
  },
  data: function () {
    var sortOrders = {}
    this.columns.forEach(function (key) {
      sortOrders[key.field] = 1
    })
    return {
      sortKey: '',
      sortOrders: sortOrders
    }
  },
  computed: {
    filteredData: function () {
      var sortKey = this.sortKey
      var columns = this.columns
      var filterKey = this.filterKey && this.filterKey.toLowerCase()
      var order = this.sortOrders[sortKey] || 1
      var data = this.data
      if (filterKey) {
        data = data.filter(function (row) {
         
          return Object.keys(row).some(function (key) {

              var display = '';

              if( row[key] != null && (Array.isArray(row[key]) || (typeof row[key] === 'object'))){

                column = columns.filter(function (row) {
                  return row.field.indexOf(key) >= 0
                })

                var field = column[0].field;
                var style = column[0].style;

                if (field.indexOf(".") >= 0){  
                  var obj =  field.split('.');

                  if(obj.length == 3){
                    display =  row[obj[0]][obj[1]][obj[2]];
                  }else{
                    display =  row[obj[0]][obj[1]];
                  }
                }

                if (field.indexOf(":") >= 0 && style.indexOf("multi") >= 0){  
                  var obj =  field.split(':');
                  var role = [];
                  
                  row[obj[0]].forEach(function(item,index){
                      role.push(item[obj[1]]); 
                  });

                  display = role.join(", ").toUpperCase();

                }

              }else{
                
                display = row[key]
              }

              return String(display).toLowerCase().lastIndexOf(filterKey) > -1

          }) 

        })

        vuegrid.pagination.total = data.length;

      }
      if (sortKey) {
        data = data.slice().sort(function (a, b) {

          if (sortKey.indexOf(".") >= 0){  
            var obj =  sortKey.split('.');

            if(obj.length == 3){
              a = a[obj[0]][obj[1]][obj[2]]
              b = b[obj[0]][obj[1]][obj[2]]
            }else{
              a = a[obj[0]][obj[1]]
              b = b[obj[0]][obj[1]]
            }
          }else if (sortKey.indexOf(":") >= 0 ){  
            var obj =  sortKey.split(':');
            var roleA = [];
            var roleB = [];
            
            a[obj[0]].forEach(function(item,index){
                roleA.push(item[obj[1]]); 
            }); 

            b[obj[0]].forEach(function(item,index){
                roleB.push(item[obj[1]]); 
            });

            a = roleA.join(", ").toUpperCase();
            b = roleB.join(", ").toUpperCase();

          }else{
            a = a[sortKey]
            b = b[sortKey]
          }

          return (a === b ? 0 : a > b ? 1 : -1) * order
        })
      }

      return data
    },
    runner : function () {
      var current_page = this.current_page;
      var per_page = this.per_page;
      return (current_page - 1) * per_page;
    }
  },
  filters: {
    capitalize: function (str) {
      return str.charAt(0).toUpperCase() + str.slice(1)
    }
  },
  methods: {
    sortBy: function (key) {
      this.sortKey = key
      this.sortOrders[key] = this.sortOrders[key] * -1
    },
    uriaction : function (uri , id) {
      return uri + '/' +  id;
    },
    checkNumbers : function(amount){
      // if($.isNumeric(amount)){
        // return accounting.formatNumber(amount);
      // }else{
        return amount;
      // }
    },
    checkDisplay : function(data,key){

      var field = key.field;
      var style = key.style;
      var display = data[field];

      if (field.indexOf(".") >= 0){  
        var obj =  field.split('.');

        if(obj.length == 3){
          display =  data[obj[0]][obj[1]][obj[2]];
        }else{
          display =  data[obj[0]][obj[1]];
        }
      }

      if (field.indexOf(":") >= 0 && style.indexOf("multi") >= 0){  
        var obj =  field.split(':');
        var role = [];
        
        data[obj[0]].forEach(function(item,index){
            role.push(item[obj[1]]); 
        });

        display = role.join(", ").toUpperCase();

      }

      return this.checkNumbers(display);
    }
  }
})


var vuegrid = new Vue({
  el: '#griddata',
  data: {
    timer:'',
    searchQuery: '',
    gridColumns: window.column,
    gridData: window.data,
    gridBuilder: window.builder,
    gridApi: window.api,
    gridNew: window.add,
    gridNewDesc: window.addDesc,
    gridActions: window.actions,
    gridActionsSimple: window.simple,
    pagination: {
      total: window.pagination.total,
      per_page: window.pagination.per_page,
      from: window.pagination.from,
      to: window.pagination.last_page,
      last_page: window.pagination.last_page,
      current_page: window.pagination.current_page
    },
    offset: 4,
  },
  computed : {
    isActived: function () {
            return this.pagination.current_page;
        },
    pagesNumber: function () {
        if (!this.pagination.to) {
            return [];
        }
        var from = this.pagination.current_page - this.offset;
        if (from < 1) {
            from = 1;
        }

        var to = from + (this.offset * 2);

        if (to >= this.pagination.last_page) {
            to = this.pagination.last_page;
        }

        var pagesArray = [];

        while (from <= to) {
            pagesArray.push(from);
            from++;
        }
        return pagesArray;
    }
  },
  mounted: function () {
    this.fetchItems(this.pagination.current_page);
    this.timer = setInterval(function () { 
      this.fetchItems(this.pagination.current_page);
      }.bind(this), 60000)
  },
  methods: {
      fetchItems: function (page) {
          var data = {page: page};
          this.$http.get(this.gridApi + '?page=' + page + '&search=' + this.searchQuery).then(function (response) {
              //look into the routes file and format your response
              this.gridData = response.data.data;
              this.pagination.current_page = (response.data.current_page > response.data.last_page ) ? 1 : response.data.current_page;

              this.pagination.total = response.data.total;
              this.pagination.last_page = response.data.last_page;
              this.pagination.to = response.data.last_page;
              // this.$set('pagination', response.data.pagination);
          }, function (error) {
              // handle error
          });
      },
      changePage: function (page) {
          this.pagination.current_page = page;
          this.fetchItems(page);
      }
  },
  beforeDestroy() {
    clearIntervall(this.timer)
  }
})


</script>
@endpush