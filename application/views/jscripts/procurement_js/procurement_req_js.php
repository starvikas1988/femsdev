<script>
	$(document).ready(function() {
		baseURL = "<?php echo base_url(); ?>";
		$(document).on('click', '.assets_wise_req_data', function() {

			var assets_id = $(this).attr('assets_id');
			var count_id = $(this).attr('count_id');

			var request_url = "<?php echo base_url('procurement/get_request_list/assets'); ?>";
			var datas = {
				'assets_id': assets_id
			};
			process_ajax(function(response) {
				var res = JSON.parse(response);
				$("#collapseExample_tabledata_" + count_id).html(res.htmldata);

			}, request_url, datas, 'text');

		});

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		$(".approveModalshow").click(function() {

			var req_id = $(this).attr("req_id");

			request_url = baseURL + 'procurement/reqItemApprovHtml';
			datas = {
				'req_id': req_id,
			};
			process_ajax(function(htmldata) {

				$('#approveModal').html(htmldata);
				$("#approveModal").modal('show');
			}, request_url, datas, 'text');

		});

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		$(".manageRequestHtml").click(function() {

			var req_id = $(this).attr("req_id");

			request_url = baseURL + 'procurement/manageRequestHtml';
			datas = {
				'req_id': req_id,
			};
			process_ajax(function(htmldata) {

				$('#manageRequestModal').html(htmldata);
				$("#manageRequestModal").modal('show');
			}, request_url, datas, 'text');

		});

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		$(".search_more_vendor").click(function() {

			var search_vendor_ids = $('select#search_vendor_ids').val();
			if (search_vendor_ids != '') {
				request_url = baseURL + 'procurement/getSerachVendors';
				datas = {
					'vendor_ids': search_vendor_ids,
				};
				process_ajax(function(response) {

					list = "";
					var res = JSON.parse(response);
					var c = 1;
					$.each(res.vendors, function(index, element) {

						list += `<tr>
									<td><input type="checkbox" class="contact_vendor_check"  onclick="checkme(this.value)" name="contact_vendor_ids[]" value="${element.id}"></td>
									<td>${element.vnd_name}</td>
									<td>${element.vnd_phone}</td>
									<td><div class="modal-btn">
											<button type="button" class="btn btn-sm" title="View More" vendor_id="${element.id}" vendor_name="${element.vnd_name}">
												<i class="fa fa-eye" aria-hidden="true"></i>
											</button>
										</div></td>
									
								</tr>`;
						c++;

						var chekVal = element.id;

						$('#search_vendor_ids option[value="' + chekVal + '"]').prop('disabled', true);
						$("#search_vendor_ids").val('default');
						$('.selectpicker').selectpicker('refresh');

					});

					$('.priority_vendors tr:last').after(list);
					

				}, request_url, datas, 'text');
			}

		});

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		$(".contactVendorBulk").click(function() {

			var assets_id = $(this).attr("assets_id");

			request_url = baseURL + 'procurement/contactVendorBulkHtml';
			datas = {
				'assets_id': assets_id,
			};
			process_ajax(function(response) {

				var res = JSON.parse(response);
				$('.sendReqVendor').attr('req_id', res.req_id);
				$('.sendReqVendor').attr('assets_id', res.assets_id);

				//$('#vendorContactList').html(htmldata);
				$("#vendorContactList").modal('show');
			}, request_url, datas, 'text');

		});

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		$(".sendReqVendor").click(function() {

			var checkedVals = $('.contact_vendor_check:checkbox:checked').map(function() {
				return this.value;
			}).get();
			var vendor_ids = checkedVals.join(",");

			var req_id = $(this).attr("req_id");
			var assets_id = $(this).attr("assets_id");

			request_url = baseURL + 'procurement/sendReqVendorSubmit';
			datas = {
				'assets_id': assets_id,
				'req_id': req_id,
				'vendor_ids': vendor_ids,
			};

			process_ajax(function(response) {
				swal({
					title: "Success!",
					text: 'Vendor Selection Has Been Completed. Please wait till vendor upload Quoation.',
					icon: "success"
				}).then(function() {
					window.location.reload();
					//startRefresh();
				});

			}, request_url, datas, 'text');

		});

		

		

	}); // end of document ready

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//$(document).on('click', '.chatbox', function(e) {
		function openChatWindow(data){
			
			var po_id = data.getAttribute("po_id");
			
			request_url = baseURL + 'procurement/openChatWindow';
			datas = {
				'po_id': po_id,
			};
			process_ajax(function(htmldata) {

				$('#chatBoxModal').html(htmldata);
				//$('.modal-body').scrollTop($('.modal-body')[0].scrollHeight);
				$('#chat_po_id').val(po_id);
				$("#chatBoxModal").modal('show');
			}, request_url, datas, 'text');
		}
		
		

	//});

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	
	$(document).on('click', '#send_group_chat', function() {

		var group_chat_message = $('#group_chat_message').val();
		var po_id = $('#chat_po_id').val();

		if(group_chat_message!='' && po_id!='')
		{

			request_url = baseURL + 'procurement/chatSubmit';
			datas = {
				'po_id': po_id,
				'group_chat_message':group_chat_message,
			};
			process_ajax(function(htmldata) {

				$('#chatBoxModal').html(htmldata);
				//$('.modal-body').scrollTop($('.modal-body')[0].scrollHeight);
			
				$('#chat_po_id').val(po_id);
				//$("#chatBoxModal").modal('show');
				
			}, request_url, datas, 'text');
		}
		else
		{

			swal({
					title: "Warning!",
					text: "Please type any comment...",
					icon: "warning"
				});

		}

	});


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	$(document).on('click', '.remove_chat', function() {
		
		var query_id = $(this).attr("query_id");
		var po_id = $(this).attr("po_id");

		swal({
			title: "Are you sure??",

			icon: 'warning',
			buttons: ["No", "Yes"],

		}).then((willDelete) => {
			if (willDelete) {

		request_url = baseURL + 'procurement/chatRemove';
		datas = {
			'query_id': query_id,
			'po_id':po_id,
			
		};
		process_ajax(function(htmldata) {

			$('#chatBoxModal').html(htmldata);
			$('#chat_po_id').val(po_id);
			//$("#chatBoxModal").modal('show');
		}, request_url, datas, 'text');

	}

});

	});

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	$(document).on('click', '.makeapprove', function() {

		var req_id = $(this).attr("req_id");
		var approve = $(this).attr("approve");
		var asset_id = $(this).attr("asset_id");

		if (approve == '1') {
			var msg = "Request has been Approved successfully";
			var warnmsg = "Are you sure to Approve?";
		} else {
			var msg = "Request has been Declined & Closed successfully";
			var warnmsg = "Are you sure to Decline?";
		}


		swal({
			title: warnmsg,

			icon: 'warning',
			buttons: ["No", "Yes"],

		}).then((willDelete) => {
			if (willDelete) {

				request_url = baseURL + 'procurement/reqStatuschange';
				datas = {
					'req_id': req_id,
					'approve_status': approve,
					'asset_id': asset_id,
				};
				process_ajax(function(response) {



					swal({
						title: "Success!",
						text: msg,
						icon: "success"
					}).then(function() {
						window.location.reload();
						//startRefresh();
					});


				}, request_url, datas, 'text');

			}

		});
	});

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	$(document).on('click', '.contactVendorSingle', function() {

		var assets_id = $(this).attr("assets_id");
		var req_id = $(this).attr("req_id");

		request_url = baseURL + 'procurement/contactVendorSingleHtml';
		datas = {
			'assets_id': assets_id,
			'req_id': req_id,
		};
		process_ajax(function(response) {

			var res = JSON.parse(response);
			$('.sendReqVendor').attr('req_id', res.req_id);
			$('.sendReqVendor').attr('assets_id', res.assets_id);

			//$('#vendorContactList').html(htmldata);
			$("#vendorContactList").modal('show');
		}, request_url, datas, 'text');

	});

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	$(document).on('click', '.viewVendorQuote', function() {

		var assets_id = $(this).attr("assets_id");
		var req_id = $(this).attr("req_id");

		request_url = baseURL + 'procurement/viewVendorQuoteModal';
		datas = {
			'assets_id': assets_id,
			'req_id': req_id,
		};
		process_ajax(function(htmldata) {

			$('#viewVendorQuoteModal').html(htmldata);
			$("#viewVendorQuoteModal").modal('show');
		}, request_url, datas, 'text');

	});

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	$(document).on('click', '.openpr', function() {
		var req_id = $(this).attr("req_id");
		request_url = baseURL + 'procurement/openPrModalData';
		datas = {
			'req_id': req_id,
		};
		process_ajax(function(htmldata) {

			$('#openPrModal').html(htmldata);
			$("#openPrModal").modal('show');
		}, request_url, datas, 'text');

	});

	//+++++++++++++++++++++++++++++++++++++++ request page approve/decline all ++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$(document).on('click', '.statusChangeAll', function() {


		var checkedValues = $('.req_assets:checkbox:checked').map(function() {
			return this.value;
		}).get();

		var approve = $(this).attr("approve");
		var req_id = $(this).attr('req_id');

		if (approve == '1') {
			var msg = "Assets Request has been Approved successfully";
			var warnmsg = "Are you sure to Approve?";
		} else {
			var msg = "Assets Request has been Declined successfully";
			var warnmsg = "Are you sure to Decline?";
		}

		swal({
			title: warnmsg,

			icon: 'warning',
			buttons: ["No", "Yes"],

		}).then((willDelete) => {
			if (willDelete) {

				request_url = baseURL + 'procurement/reqAssetsStatuschangeAll';
				datas = {
					'checkedValues': checkedValues,
					'approve_status': approve,
					'req_id': req_id,
				};
				process_ajax(function(response) {

					swal({
						title: "Success!",
						text: msg,
						icon: "success"
					}).then(function() {
						window.location.reload();
					});


				}, request_url, datas, 'text');

			}

		});

	});

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function checkme(value) {

		var numberNotChecked = $('input[name="contact_vendor_ids[]"]:checked').length;

		if (Number(numberNotChecked) > Number(3)) {
			swal({
				title: "Warning!",
				text: "Maximum 3 Vendors are allowed!",
				icon: "warning"
			}).then(function() {

				$('.sendReqVendor').prop('disabled', true);
				var style = $('.sendReqVendor').attr('style'); //it will return string
				// update style as
				style += ';display:none';
				$('.sendReqVendor').attr('style', style);

			});
		}
		else if(Number(numberNotChecked)==0){

			$('.sendReqVendor').prop('disabled', true);
				var style = $('.sendReqVendor').attr('style'); //it will return string
				// update style as
				style += ';display:none';
				$('.sendReqVendor').attr('style', style);

		} else {
			
			$('.sendReqVendor').prop('disabled', false);
			var style = $('.sendReqVendor').attr('style'); //it will return string
			// update style as
			style += ';display:block';
			$('.sendReqVendor').attr('style', style);

		}

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function bulkApproveDecline(type, asset_id, asset_name) {
		if (type == '1') {
			var title = "Bulk Approve";
			var text = 'Are you sure to Approve all request under ' + asset_name + '?';
		} else {
			var title = "Bulk Decline";
			var text = 'Are you sure to Decline all request under ' + asset_name + '?';
		}


		swal({
			title: title,
			text: text,
			icon: "warning"
		}).then(function() {
			request_url = baseURL + 'procurement/bulkRequestApproveDecline';
			datas = {
				'assets_id': asset_id,
				'type': type,
			};

			process_ajax(function(response) {
				swal({
					title: "Success!",
					text: 'All Request status has been updated successfully',
					icon: "success"
				}).then(function() {
					window.location.reload();
					//startRefresh();
				});

			}, request_url, datas, 'text');
		});
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function internalStockManage(data) {

		var req_id = data.getAttribute("req_id");
		var req_asset_id = data.getAttribute("req_asset_id");
		swal({
			title: "Manage From Internal Stock!",
			text: 'Are you sure to manage it from Internal Stock?',
			icon: "warning",
			buttons: ["No", "Yes"],
		}).then((willDelete) => {
			if (willDelete) {
				request_url = baseURL + 'procurement/manageFromInternalStockmodal';
				datas = {
					'req_id': req_id,
					'req_asset_id': req_asset_id,
				};

				process_ajax(function(response) {
					$('#internalStockManageModal').html(response);
					$("#internalStockManageModal").modal('show');

				}, request_url, datas, 'text');
			}
		});

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function viewRequest(data) {

		var req_id = data.getAttribute("req_id");
		//var req_asset_id = data.getAttribute("req_asset_id");

		request_url = baseURL + 'procurement/viewRequestDetails';
		datas = {
			'req_id': req_id,
			// 'req_asset_id': req_asset_id,
		};

		process_ajax(function(response) {
			$('#viewRequestDataModal').html(response);
			$("#viewRequestDataModal").modal('show');

		}, request_url, datas, 'text');


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
</script>