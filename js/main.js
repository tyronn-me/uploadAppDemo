(function($) {

	$(document).ready(function() {

		// Notifications

		$('.toast').toast();

		// Form validation

		$('#userSubmit').on("click", function() {

			var userName = $('#userName').val();
			var userEmail = $('#userEmail').val();
			var userPassword = $('#userPassword').val();
			var userPasswordConfirm = $('#userPasswordConfirm').val();
			var userCompany = $('#userCompany').val();

			if ( userName == "" || userEmail == "" || userPassword == "" || userCompany == "" ) {
				$('#userToast').find(".toast-body").html("Please fill in all fields.");
				$('#userToast').toast("show");
				return false;
			}

			if ( userPassword != userPasswordConfirm ) {
				$('#userToast').find(".toast-body").html("Please confirm your password");
				$('#userToast').toast("show");
				return false;
			}

		});

		// Upload ( drag and drop ) functionality

		window.Dropzone.autoDiscover = false;

		// $('#bannerPreviewUploadForm');

		// Preview Page
		var highlightCount = 0;

		$("body").on("click", '.preview_row', function() {

			var elem = $(this);
			if ( elem.hasClass("highlighted") == false ) {
				elem.addClass("highlighted");
				highlightCount++;
			} else {
				elem.removeClass("highlighted");
				highlightCount--;
			}

			if ( highlightCount <= 0 ) {
				highlightCount = 0;
			}

			if ( highlightCount < 1 ) {
				$('#previewButton').prop("disabled", true);
				$('#previewCopyButton').prop("disabled", true);
				$('#previewButton').css({ opacity : 0.5 });
				$('#previewCopyButton').css({ opacity : 0.5 });
			} else {
				$('#previewButton').prop("disabled", false);
				$('#previewCopyButton').prop("disabled", false);
				$('#previewButton').css({ opacity : 1 });
				$('#previewCopyButton').css({ opacity : 1 });
			}

		});

		$('#creative_preview_link').on("click", function() {
			if ( $(this).hasClass("disabled") === true ) {
				return false;
			} else {
				var linkArr = [],
					  link;

				$(".selected").each(function() {
					var id = $(this).data("creativeid");
					linkArr.push(id);
				});

				link = '<a href="' + siteURL + 'Preview/creatives?id=' + linkArr.toString() + '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Copy and paste this link to share.">' + siteURL + 'preview/creatvies?id=' + linkArr.toString() + '</a>';

				$('#previewLink').html("").append(link).fadeIn(500, function() {
					$('[data-toggle="tooltip"]').tooltip();
				});
				return false;
			}
		});

		// var clipboard = new ClipboardJS('#previewCopyButton');

		$('body').on("click", '#previewCopyButton', function() {
			var linkArr = [],
				  i;

			$(".highlighted").each(function() {
				var link = $(this).data("creativelink");
				linkArr.push(link);
			});

			for(i = 0; i < linkArr.length; i++) {
				$('#copyField').append(linkArr[i] + "\n");
			}

			clipboard.on('success', function(e) {
				$.notify({
					text : "Your links have been copied!"
				});
			    e.clearSelection();
			});

			$('#previewLinksToCopy').fadeIn(500);

		});

		$('#preview_modal_close').on("click", function(event) {
			event.preventDefault();
			$('#preview_modal').removeClass("pop");
			setTimeout(function() {
				$('#preview_modal iframe').remove();
			}, 1000);
		});

		$('body').on("keyup", '#clientSelect', function() {
			var val = $('#clientSelect').val().toLowerCase();
			$('.preview_row').each(function () {
				var elem = $(this);
				var cat = $(this).data("category");
				if ( cat.toLowerCase().indexOf(val) >= 0 ) {
					elem.fadeIn(300);
				} else {
					elem.fadeOut(300);
				}
			});
		});

		$('#loadMoreRows').on("click", function(event) {
			event.preventDefault();
			showLoader();
			var id = $('.preview_row').last().data("creativeid");
			getPreviewBoxes(id);
		});

		// Creative Previews

		$('body').on("click", '.refreshFrame', function(event) {
			event.preventDefault();
			var src = $(this).parent().parent().find('iframe').attr("src");
			$(this).parent().parent().find('iframe').attr("src", src);
			return false;
		});

		$("body").on("click", '.creativePreivewFrameLink', function() {

			$(this).addClass("active").siblings().removeClass("active");
			$('#creativePreview_content').html("");

			var link = $(this).data("frameurl"),
					version = $(this).data("unitversion"),
					width = $(this).data("framewidth"),
					height = $(this).data("frameheight"),
					content;

					content = $('<div class="singleCreativeFrame"><iframe src="' + link + '" width="' + width + '" height="' + height + '"></iframe><p><a href="#" class="refreshFrame"><i class="fas fa-sync-alt"></i><a></p></div>');

					$('#creativePreview_content').append(content);

		});

		$('.creativePreivewFrameLink').first().trigger("click");

		// Users

		$('.nav-link').on('click', function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		})

		// Client front end

		$('#exampleModalScrollable').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var src = button.data('unitlink');
			var unitwidth = button.data('unitwidth');
			var unitheight = button.data('unitheight');
			var unitname = button.data('unitname');
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
			modal.find('.modal-title').html(unitname);
		  modal.find('iframe').attr('src', src);
			modal.find('iframe').attr('width', unitwidth);
			modal.find('iframe').attr('height', unitheight);
			modal.find('.modal-body').css({ 'height' : ( unitheight + 50 ) + "px" });
		});

	});

	$(window).load(function() {

		var loggedIn = $('.logged-in');

		if ( $('#preview-wrapper').length > 0 ) {
			getPreviewBoxes();
		}

		hideLoader();

	});

	function showLoader() {
		setTimeout(function() {
			$('#BPloader').fadeIn(500);
		}, 500);
	}

	function hideLoader() {
		setTimeout(function() {
			$('#BPloader').fadeOut(500);
		}, 500);
	}

	function searchForCampaign(campaign) {
		var exists;

		$.ajax({
			type: "POST",
			url: siteURL + "Home/checkCampaignExist",
			cache: false,
			data : { campaign : campaign },
			success: function(data){
				if ( data == "Fine" ) {
				} else {
					$.notify({
						text : "Campaign with the name you chose already exists",
						status : "high"
					});
				}
			},
			complete: function() {
				hideLoader();
			}
		});

		return exists;
	}

	function getPreviewBoxes(id) {

		var clientArr = [];

		if ( !id ) {
			id = 0;
		}

		$.ajax({
			type: "POST",
			url: siteURL + "Preview/getPreviewBoxes",
			cache: false,
			dataType: 'json',
			data : { id : id },
			success: function(data){

				$.each(data, function(index, element) {
						var boxDimentions = element.Dimentions;
						var boxID = element.ID;
						var boxDimentionsArr = boxDimentions.split("x");
						var box = $('<tr data-creativeid="' + boxID + '" class="preview_row" data-category="' + element.Client + '" data-creativelink="' + element.CreativeLink + '"><td>' + element.CreativeName + '</td><td>' + element.Dimentions + '</td><td>' + element.Client + '</td><td>' + element.Project + '</td><td>' + element.uploadedBy + '</td><td>' + element.dateUploaded + '</td><td>' + element.Status + '</td><td><a class="icons preview_link" href="' + element.Link + '" data-width="' + boxDimentionsArr[0] + '" data-height="' + boxDimentionsArr[1] + '" data-name="' + element.CreativeName + '"></a></td></tr>');
						$("#preview-table tbody").append(box);

						if ( $.inArray(element.Client, clientArr) === -1 ) {
							clientArr.push(element.Client);
		        		}
		        });

		        var i;
				for(i = 0; i < clientArr.length; i++) {
					$('#clientSelect').append('<option value="' + clientArr[i]  + '">' + clientArr[i]   + '</option>');
				}

			},
			complete : function(data) {
				console.log("Complete");
				hideLoader();
			}
		});

	}

})(jQuery);
