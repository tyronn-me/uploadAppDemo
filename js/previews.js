(function($) {

  var currentBtn;

  $(document).ready(function() {
    var campaignListItem = $('.campaignListItem');

    $('#previewContentArea').on("click", '.createiveBoxes', function() {
      var __this = $(this);

      __this.toggleClass("selected");

      var selectCount = $('.selected');
      if ( selectCount.length > 0 ) {
        $('.preview_nav_ui').removeClass("disabled");
      } else {
        $('.preview_nav_ui').addClass("disabled");
      }

    });

    $('#delete_creatives').on("click", function() {
			if ( $(this).hasClass("disabled") === true ) {
				return false;
			} else {
				var linkArr = [];

				$(".selected").each(function() {
					var id = $(this).data("creativeid");
					linkArr.push(id);
				});

        var data_str = linkArr.join(",");

        $.ajax({
          type: "POST",
          url: siteURL + "Preview/delete_creatives",
          data: { linkArr : data_str },
          cache: false,
          success: function(data){

            $.notify({
  						text : "Creatives have been deleted"
  					});

            console.log(data);

          },
          complete: function() {

          }
        });

				return false;
			}
		});

    campaignListItem.on("click", function() {
      var campaign = $(this).data("campaign");
      var clientName = $(this).data("client");

      if ( campaign != null && clientName != null ) {

      var procount = $(this).data("procount");
      currentBtn = $(this).parent().children().index(this);
      console.log(currentBtn);

      $('#campaign_bannerPreviewUploadForm').find("#campainName").attr("value", campaign);
      $('#campaign_bannerPreviewUploadForm').find("#clientName").attr("value", clientName);


      $(this).addClass("active").siblings().removeClass("active");

      $('#previewLoader').fadeIn(function() {

        $('#previewMainContentArea').fadeOut();

        $('#previewWelcome').fadeOut();
        $('#previewContentArea').html("");

        $.ajax({
          type: "POST",
          url: siteURL + "Preview/getPreviewBoxes",
          data: { campaign : campaign },
          cache: false,
          success: function(data){

            $('#previewContentArea').append(data);

              $('.createiveBoxes').each(function(index) {
                var __this = $(this);
                setTimeout(function() {
                  __this.addClass("popped");
                }, 100 * index);
              });

          },
          complete: function() {
            $('#previewMainContentArea').fadeIn(function() {
              $('#previewLoader').fadeOut();
            });
          }
        });

      });

    }

    });

  });

  $(window).on("load", function() {

    $('#campaign_bannerPreviewUploadForm').dropzone({
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 2, // MB
			clickable: true,
			acceptedFiles: '.zip',
			init: function() {

        var uploadDropzone = this;

        this.on("error", function(errorMessage, XMLHttpRequest, xhr) {
					$.notify({
						text : errorMessage + " :: " + XMLHttpRequest + ":: " + xhr
					});
				});

        this.on("complete", function(file) {
          uploadDropzone.removeAllFiles();
        });

        this.on("success", function(file, response) {

          console.log(file);

          var clientName = $('#clientName').val();
  				var uploadedBy = $('#uploadedBy').val();
  				var uploadedDate = $('#uploadedDate').val();
  				var campainName = $('#campainName').val();
          var procount = $('#proCount').find('span').html();
          var procount = parseInt(procount)

          $('#previewLoader').fadeIn(function() {

            $('#previewMainContentArea').fadeOut();

            $('#previewWelcome').fadeOut();
            $('#previewContentArea').html("");

            $.ajax({
              type: "POST",
              url: siteURL + "Preview/getPreviewBoxes",
              data: { campaign : campainName },
              cache: false,
              success: function(data){

                console.log(data);

                $('#previewContentArea').append(data);

                  $('.createiveBoxes').each(function(index) {
                    var __this = $(this);
                    setTimeout(function() {
                      __this.addClass("popped");
                    }, 100 * index);
                  });

              },
              complete: function() {
                $('#previewMainContentArea').fadeIn(function() {
                  $('#previewLoader').fadeOut();
                });
              }
            });

          });

        });

			},
			sending: function(file, xhr, formData) {
				formData.append("clientName", $('#clientName').val());
				formData.append("uploadedBy", $('#uploadedBy').val());
				formData.append("uploadedDate", $('#uploadedDate').val());
				formData.append("campainName", $('#campainName').val());
			},
			dictDefaultMessage : '<i class="fas fa-cloud-upload-alt"></i> Drag &amp; Drop zip file here<br/><strong>Click to browse files.</strong>',
			accept: function(file, done) {
				done();
			},
			uploadprogress: function(file, progress, bytesSent) {

        $('.progress-bar').css({
          width : progress + "%"
        });

			}
		});

  });

})(jQuery);
