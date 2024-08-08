var ManageBLog = function() {
  var blog = function() {

      var csr_token = $('meta[name="csrf-token"]').attr('content')

      function formatRepo(repo) {
          if (repo.loading) return repo.text;

          var markup = "<div class='select2-result-repository clearfix'>" +
              "<div class='select2-result-repository__meta'>" +
              "<div class='select2-result-repository__title'>"+repo.first_name+" "+repo.last_name+"</div></div></div>";

          return markup;
      }

      function formatRepoSelection(repo) {
          var username;
          if (repo.id != "") {
              username = repo.first_name+" "+repo.last_name;
          } else {
              username = repo.text;
          }
          return username;
      }

      $("#blog_assign_to_user_modal").on("shown.bs.modal", function() {
          $("#m_user_selector").select2({
              placeholder: "Select User",
              ajax: {
                  type: "POST",
                  url: '/admin/blogs/getStringedUser',
                  dataType: 'json',
                  delay: 250,
                  data: function(params) {
                      return {
                          _token: csr_token,
                          user_string: params.term, // search term
                          page: params.page
                      };
                  },
                  processResults: function(data, page) {
                      return {results: data};
                  },
                  cache: true
              },
              escapeMarkup: function(markup) {
                  return markup;
              }, // let our custom formatter work
              minimumInputLength: 1,
              templateResult: formatRepo,
              templateSelection: formatRepoSelection,
              initSelection: function(element, callback){
                  var user_id = element.data('user_id');
                  var first_name = element.data('first_name');
                  var last_name = element.data('last_name');
                  return callback({id: user_id, first_name: first_name, last_name: last_name });;
              }
          })
      })

      var blogsDatatable = $('#m_blog_datatable');

      blogsDatatable.mDatatable({
        // datasource definition
        data: {
          type: 'remote',
          source: {
  			read: {
  				url: '/admin/blogs/getBlogDatas',
                  method: 'GET',
  			},
  		},
          pageSize: 5,
        },

        // column sorting
        sortable: true,

        pagination: true,

        toolbar: {
          // toolbar items
          items: {
            // pagination
            pagination: {
              // page size select
              pageSizeSelect: [5, 10, 20, 30, 50, 100],
            },
          },
        },

        search: {
          input: $('#generalSearch'),
        },

        // columns definition
        columns: [{
            field: 'blog_title',
            title: 'Blog Title',
            width: 200,
          }, {
              field: 'like_count',
              title: 'Likes',
              width: 100,
          }, {
              field: 'poster_name',
              title: 'Poster',
              width: 100,
          }, {
              field: 'position',
              title: 'Position',
              width: 100,
              textAlign: 'center',
              overflow: 'visible',
              template: function (row, index, datatable) {
                  return '\
                      <a href="javascript:;" data-blog_id="'+row.id+'" class="change_blog_position_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon" title="Position">\
                      <span>'+row.position+'</span>\
                      </a>\
                  ';
              }
          }, {
              field: "is_show",
              width: 100,
              title: "Show / Hidden",
              sortable: false,
              overflow: 'visible',
              template: function(row, index, datatable) {
                  var dropup = (datatable.getPageSize() - index) <= 4
                      ? 'dropup'
                      : '';

                  var status = {
                      0: {
                          'title': 'Hidden',
                          'state': 'danger'
                      },
                      1: {
                          'title': 'Show',
                          'state': 'accent'
                      }
                  };

                  return '\
                  <div class="dropdown ' + dropup + '">\
                  <a href="javascript:;" style="padding: 5px 10px;" class="btn m-btn--hover-metal" data-toggle="dropdown">\
                  <span class="m--font-bold m--font-' + status[row.is_show].state + '"> \
                  ' + status[row.is_show].title + ' </span>\
                  </a>\
                  <div class="dropdown-menu dropdown-menu-right">\
                  <a class="dropdown-item blog_hidden_btn" data-blog_id="' + row.id + '" data-status="0" href="javascript:;">\
                  <span class="m--font-bold m--font-' + status[0].state + '">' + status[0].title + '</span></a>\
                  <a class="dropdown-item blog_show_btn" data-blog_id="' + row.id + '" data-status="1" href="javascript:;">\
                  <span class="m--font-bold m--font-' + status[1].state + '">' + status[1].title + '</span></a>\
                  </div>\
                  </div>\
                  ';
              }
          }, {
              field: "Actions",
              width: 120,
              title: "Actions",
              sortable: false,
              overflow: 'visible',
              template: function (row, index, datatable) {
                  var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                  return '\
                      <a href="javascript:;" data-blog_id="'+row.id+'" class="blog_assing_user_btn m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Change User">\
                      <i class="la la-user"></i>\
                      </a>\
                      <a href="'+domain_url+'/blogs/update/'+row.id+'" class="blog-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                      <i class="la la-edit"></i>\
                      </a>\
                      <a href="javascript:;" data-blog_id="'+row.id+'" class="blog-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete ">\
                      <i class="la la-trash"></i>\
                      </a>\
                  ';
              }
          }],
      });

      $(document).on('click', '.blog_hidden_btn', function() {
          var $this = $(this);
          var blogId = $this.data('blog_id');
          $.ajax({
              url: '/admin/blogs/hidden/' + blogId,
              type: 'get',
              success: function(response) {
                  if (response.result == "success") {
                      blogsDatatable.reload();
                  }
              },
              error: function(error) {
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.blog_show_btn', function() {
          var $this = $(this);
          var blogId = $this.data('blog_id');
          $.ajax({
              url: '/admin/blogs/unhidden/' + blogId,
              type: 'get',
              success: function(response) {
                  if (response.result == "success") {
                      blogsDatatable.reload();
                  }
              },
              error: function(error) {
                  console.log(error);
              }
          });
      });

      $(document).on('click', '.blog-delete_btn', function(){
          var $this = $(this);

          swal({
              title: 'Are you sure?',
              text: "Delete Blog !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: ' Yes !',
              confirmButtonClass: "btn m-btn--air btn-outline-danger m-btn m-btn--wide",
              cancelButtonClass: "btn m-btn--air btn-outline-primary m-btn m-btn--wide",
          }).then(function(result) {
              if (result.value) {
                  var blogId = $this.data('blog_id');
                  $.ajax({
                      url: '/admin/blogs/destroy/'+blogId,
                      type: 'get',
                      success: function(response){
                          if (response.result == "success") {
                              swal({
                                  "title": "Success",
                                  "text": "Blog Deleted !.",
                                  "type": "success",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                              blogsDatatable.reload();
                          } else if (response.result == "error") {
                              swal({
                                  "title": "Faild",
                                  "text": "Can not find Blog !.",
                                  "type": "error",
                                  "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                              });
                          }
                      },
                      error: function(error){
                          console.log(error);
                      }
                  });
              }
          });
      });

      $(document).on('click', '.blog_assing_user_btn', function() {
          var $this = $(this);

          var blogId = $this.data('blog_id');

          $.ajax({
              url: '/admin/blogs/getDetail/'+blogId,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      console.log(response.blog.poster_first_name);
                      $('#blog_assign_to_user_form #blog_id').val(response.blog.id);
                      $('#blog_assign_to_user_form #blog_title').val(response.blog.blog_title);
                      $('#blog_assign_to_user_form #m_user_selector').data('user_id', response.blog.user_id);
                      $('#blog_assign_to_user_form #m_user_selector').data('first_name', response.blog.poster_first_name);
                      $('#blog_assign_to_user_form #m_user_selector').data('last_name', response.blog.poster_last_name);

                      $('#blog_assign_to_user_modal').modal('show');
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $('#blog_assign_to_user_form').on('submit', function(e) {
          e.preventDefault();
          var from = $(this);

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = from.attr( 'action' );

          var formData = new FormData(from[0]);

          var submit_btn = from.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function (response) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                  if (response.result === "success") {
                      blogsDatatable.reload();

                      $('#blog_assign_to_user_modal').modal('hide');
                  }
              },
              processData: false,
              contentType: false,
              error: function(data)
             {
                 console.log(data);
             }
          });
      })

      $(document).on('click', '.change_blog_position_btn', function(){
          var $this = $(this);
          var blogId = $this.data('blog_id');

          $.ajax({
              url: '/admin/blogs/getSinglePosition/'+blogId,
              type: 'get',
              success: function(response){
                  if (response.result == "success") {
                      $('#change_blog_position_form #blog_id').val(blogId);
                      $('#change_blog_position_form #blog_position_item_container').html(response.html);

                      $('#change_blog_position_modal').modal('show');
                  }
              },
              error: function(error){
                  console.log(error);
              }
          });
      });

      $('#change_blog_position_form').on('submit', function(e) {
          e.preventDefault();

          var from = $(this);

          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
              }
          });

          var url = from.attr( 'action' );

          var formData = new FormData(from[0]);

          var submit_btn = from.find('.form-submit-btn');
          submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

          $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              success: function (response) {
                  submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                  if (response.result === "success") {
                      blogsDatatable.reload();
                      $('#change_blog_position_modal').modal('hide');
                  }
              },
              processData: false,
              contentType: false,
              error: function(data)
             {
                 console.log(data);
             }
          });
      })
  };

  return {
    // public functions
    init: function() {
      blog();
    },
  };
}();

jQuery(document).ready(function() {
  ManageBLog.init();
});
