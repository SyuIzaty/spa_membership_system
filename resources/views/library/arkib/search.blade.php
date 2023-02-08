<div>
  <div class="mx-auto pull-right">
      <div class="">
            {!! Form::open(['action' => ['Library\Arkib\ArkibController@index'], 'method' => 'GET'])!!}

              <div class="input-group">
                  <span class="input-group-btn mr-5 mt-1">
                      <button class="btn btn-info" type="submit" title="Search projects">
                          <span class="fas fa-search"></span>
                      </button>
                  </span>
                  <input type="text" class="form-control mr-2" name="search_data" placeholder="Search projects" id="term">
                  <a href="/library/arkib" class=" mt-1">
                      <span class="input-group-btn">
                          <button class="btn btn-danger" type="button" title="Refresh page">
                              <span class="fas fa-sync-alt"></span>
                          </button>
                      </span>
                  </a>
              </div>
            {!! Form::close() !!}
            {{isset($main) ? $main : ''}}
      </div>
  </div>
</div>