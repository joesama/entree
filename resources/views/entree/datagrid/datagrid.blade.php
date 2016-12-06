    <script type="text/x-template" id="grid-template">
      <table  id="datagrid" class="table table-condensed">
        <thead>
          <tr>
            <th v-for="key in columns"
              @click="sortBy(key.field)"
              :class="{ active: sortKey == key.field }">
              @{{ key.title | capitalize }}
              <span class="arrow" :class="sortOrders[key.field] > 0 ? 'asc' : 'dsc'">
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="filteredData.length < 1">
            <td :colspan="columns.length"><p>No matches found.</p></td>
          </tr>
          <tr v-for="entry in filteredData">
            <td v-for="key in columns">
              @{{entry[key.field]}}
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
                  <input type="text" class="form-control col-sm-8" name="query" v-model="searchQuery" placeholder="{{ trans('threef/entree::datagrid.search') }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" @click.prevent="fetchItems(pagination.current_page)">
                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                    {{ trans('threef/entree::datagrid.search') }}
                    </button>
                  </span>
                </div><!-- /input-group -->
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
              :columns="gridColumns"
              :filter-key="searchQuery">
            </demo-grid>
          </div>
      </div>
      <nav aria-label="..." class="text-center">
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
        <div class="col-md-8">
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
        <div class="col-md-2">
        </div>
      </nav>
    </div>
  </div>

@push('datagrid.jscript')
<script type="text/javascript">
Vue.config.debug = true;
Vue.config.devtools = true;

// register the grid component
Vue.component('demo-grid', {
  template: '#grid-template',
  replace: true,
  props: {
    data: Array,
    columns: Array,
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
      var filterKey = this.filterKey && this.filterKey.toLowerCase()
      var order = this.sortOrders[sortKey] || 1
      var data = this.data
      if (filterKey) {
        data = data.filter(function (row) {
          return Object.keys(row).some(function (key) {
            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
          })
        })
      }
      if (sortKey) {
        data = data.slice().sort(function (a, b) {
          a = a[sortKey]
          b = b[sortKey]
          return (a === b ? 0 : a > b ? 1 : -1) * order
        })
      }
      return data
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
    }
  }
})

// bootstrap the demo
var demo = new Vue({
  el: '#griddata',
  data: {
    searchQuery: '',
    gridColumns: window.column,
    gridData: window.data,
    gridBuilder: window.builder,
    gridApi: window.api,
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
    // this.fetchItems(this.pagination.current_page);
  },
  methods: {
      fetchItems: function (page) {
          var data = {page: page};
          this.$http.get(this.gridApi + '?page=' + page + '&search=' + this.searchQuery).then(function (response) {
              //look into the routes file and format your response
              console.log(response.data);
              this.gridData = response.data.data;
              this.pagination.current_page = response.data.current_page;
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
  }
})


</script>
@endpush