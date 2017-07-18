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
            <th v-if="actions" width="150px"  class="text-center">{{ trans('threef/entree::datagrid.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="filteredData.length < 1">
            <td :colspan="columns.length + 2"><p><center>{{ trans('threef/entree::datagrid.empty') }}</center></p></td>
          </tr>
          <tr v-for="(entry, index) in filteredData">
            <td class="text-center" style="background-color: #f9f9f9">@{{ runner + (index + 1 ) }}</td>
            <td v-for="key in columns" v-bind:class="[ key.style ? key.style : '']">
              <a v-if="key.file" class="btn btn-primary btn-xs" :href="createUri(entry,key)" target="_blank">
                <i class="fa fa-download" aria-hidden="true"></i>&nbsp;@{{ sanitizeUri(entry,key) }}
              </a>
              <a v-if="key.uri" :href="uriaction(key.uri.url,entry[key.uri.key])" target="_blank">@{{ display(entry,key) }}</a>
              <span v-if="!key.file && !key.uri">@{{ display(entry,key) }}</span>
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
@endpush