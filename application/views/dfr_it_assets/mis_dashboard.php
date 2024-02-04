<link href="<?=base_url()?>assets/css/search-filter/assets/css/simple-datatables-latest.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
.mb-1 {
    margin-bottom: 0.6rem !important;
}

.modal .close {
    color: #fff;
    text-shadow: none;
    opacity: 1;
    position: absolute;
    top: -15px;
    right: -14px;
    width: 35px;
    height: 35px;
    background: #0c6bb5;
    border-radius: 50%;
    transition: all 0.5s ease-in-out 0s;
}

.modal .modal-title {
    color: #fff;
}

.search-select label {
    display: block;
}

.search-select .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100%;
}

.bootstrap-select > .dropdown-toggle {
    height: 40px;
}

.search-select ul {
    max-height: 200px!important;
}

.modal-body {
    width: 100%;
}

.modal-card {
    width: 100%;
    background: #fff;
    padding: 10px 10px 5px 10px;
    margin: 0px 0 5px 0;
    box-shadow: 0 1px 2px #ccc;
    border-radius: 5px;
}

.add-btn {
    width: 40px;
    font-size: 14px;
    border-radius: 51px;
    padding: 9px;
}

.card-number {
    border-left: 5px solid #0e26e9;
    padding-left: 16px;
}

.remove-btn {
    width: 40px;
    font-size: 14px;
    border-radius: 51px;
    float: right;
    padding: 9px;
}

.overflow {
    max-height: 500px;
    overflow-y: auto;
    min-height: 98px;
}


/*new*/

.card-header {
    background: #4a69bd;
    border-bottom: 1px solid #4a69bd;
    ;
    color: white;
}

.sub-card-header {
    background: white;
    color: black;
}

.table-modal .table thead {
    background: #f3cf61;
    color: #233650;
}

.table-modal .modal-header {
    background: #4a69bd;
}
.modal-sub {
background: #3f3c3cb8;
}
.filter-widget .multiselect-container {
    width: 100%;
}

.fa-search {
    margin-right: 10px;
}

.btn-table {
    float: right;
}

.btn-check:focus + .btn-warning,
.btn-warning:focus {
    box-shadow: none;
}



.overflow {
    max-height: 500px;
    overflow-y: auto;
    min-height: 98px;
}


/*.table-fixed tbody{
display: block;
 max-height: 500px;
 min-height: 98px;
overflow-y: auto;
}
.table-fixed tr
{
display: block;
}*/

.card-header span {
    font-size: 15px;
    font-weight: bold;
}

.header {
    margin-top: 5px;
    display: inline-block;
}

.card-body {
    background: #d3e3ec;
}

.chart-box {
    padding: 30px;
    background: #fff;
    box-shadow: 0 2px 5px 1px rgba(64, 60, 67, .16);
}

.sub-head {
    font-size: 15px;
    font-weight: bold;
    color: #080808;
}

.btn-group,
.btn-group-vertical {
    width: 100%;
    background: #fff;
    border-radius: 5px;
}

.margin-gap {
    position: relative;
    bottom: 10px;
}
.bg-head{
background: #fff;
color: black;
}
.mB{
margin-bottom: 14px !important;
}
.status_btn2 {
		display: inline-block;
		padding: 2px 15px;
		font-size: 12px;
		font-weight: 400;
		color: #fff !important;
		background: #ffa700 !important;
		border-radius: 30px;
		text-transform: capitalize;
		white-space: nowrap;
		min-width: 70px;
		text-align: center;
	}	
    .m-width{
width: 1020px;
    }
    .s-btn{
float: right;
margin-left: 10px;
    }
    .dataTable-selector {
  padding: 6px;
  background: white;
  border: 1px solid #d7d0d0;
  border-radius: 3px;
}
.modal-al{
position: relative;
left: -72px;
}
.dataTable-pagination .pager a {
  font-weight: bold;
  position: relative;
  top: -20px;
  background: #ffa500a3;
}
.dataTable-pagination .active a, .dataTable-pagination .active a:focus, .dataTable-pagination .active a:hover {
  background-color: #49aacf;
  color: #fff;
}
.over-flow{
overflow-y: scroll;
height: 500px;
}
</style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 d-flex flex-column text-dark fw-bolder fs-2 mb-4 mB"><strong>Mis Dashboard</strong></h1>
            <div class="card mb-4 ">
            <div class="card-body bg-white">
                    <div class="filter-widget">
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">From Date:</label>
                                        <input type="date" value="<?=$start_date?>" class="form-control" name="start_date"> </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">To Date:</label>
                                        <input type="date" value="<?=$end_date?>" class="form-control" name="end_date"> </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Location:</label>
                                        <br>
                                        <select id="loaction" name="location_id[]" autocomplete="off" placeholder="Select Location" multiple>
                                        <?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if(in_array($loc['abbr'],$office_ids)) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-0">
                                        <button type="submit" class="blue-btn  mt-3"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> . </div>
            </div>
            <div class="card mb-4">
                <div class="card-header"> <span class="header">Total Request <?=$dfr_count[0]['total_req']?> - Requisition Wise</span>
                    <button type="button" class="btn btn-warning btn-sm btn-table" data-toggle="modal" data-target="#myModal">View</button>
                </div>
                <div class="card-body">
                    <div class="row chart-box">
                        <div class="col-md-6">
                            <canvas id="mypiechart" width="100%" height="60"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="mypiechart2" width="100%" height="60"></canvas>
                        </div>                        
                      
                    </div>
                </div>
            </div>
                <div class="card mb-4">
                <div class="card-header"> <span class=""> Inventory Stock</span> </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 margin-gap">
                            <div class=" chart-box ">
                                <canvas id="line-chart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 margin-gap">
                            <div class=" chart-box ">
                                <canvas id="multi-line-chart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class=" chart-box ">
                                <canvas id="inventory-doughnut1" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class=" chart-box ">
                                <canvas id="polarArea" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header"> <span class=""> Category</span> </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 margin-gap">
                            <div class=" chart-box ">
                                <canvas id="my-doughnut" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 margin-gap">
                            <div class=" chart-box ">
                                <canvas id="mybarchart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class=" chart-box ">
                                <canvas id="my-doughnut1" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class=" chart-box ">
                                <canvas id="myBarChart1" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              <div class="card mb-4">
                <div class="card-header"> <span class=""> Brand</span> </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 margin-gap">
                            <div class=" chart-box ">
                                <canvas id="brand-doughnut" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 margin-gap">
                            <div class=" chart-box ">
                                <canvas id="brand-barchart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class=" chart-box ">
                                <canvas id="brand-doughnut1" width="100%" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class=" chart-box ">
                                <canvas id="brand-BarChart1" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

         

        </div>
    </main>
</div>
<!-- Modal -->
 <div class="modal fade table-modal" id="myModal" role="dialog">
    <div class="modal-dialog modal-md modal-al">
        <div class="modal-content m-width">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Requisition List</h4> </div>
            <div class="modal-body" style="padding: 1px;">
                 <div class="over-flow">
                <table id="datatablesSimple" class="table table-striped " style="padding:10px;">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Requisition Number</th>
                            <th>Date of Request</th>
                            <th>Location</th>
                            <th>Department</th>
                            <th>Remarks</th>
                            <th>Total Candidate</th>
                            <th>Approve Category</th>
                            <th>Assets Request</th>
                            <th>Requirement Status</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $c = 1;
                            $active_count = 0;
                            $onbording_count = 0;                            
                            foreach($dfr_data as $value) { $dfr_id = $value['id'];
                        ?>
                        <tr>
                            <td><?=$c?></td>
                            <td><?=$value['requisition_id']?></td>
                            <td><?=$value['approved_date']?></td>
                            <td><?=$value['office_name']?></td>
                            <td><?=$value['department_name']?></td>
                            <td><?=$value['approved_comment']?></td>  
                            <td><?=$dfr_status_count[$dfr_id]?></td>
                            <td><?=$req_assets_total[$dfr_id][0]['total_assest_approve']?></td>
                            <td><?=$req_assets_total[$dfr_id][0]['total_assets_req']?></td>
                            <td><?php
                            	if($value['requisition_status'] == "A") echo '<label class="btn status_btn pb-1">Active</label>';
                                elseif($value['requisition_status'] == "CL") echo '<label style="background-color: #df0000a3;" class="btn status_btn pb-1">Closed</label>';
                                else echo "-";
                            ?></td>
							<td>
							    <?php
									if ($dfr_status_count[$dfr_id] > 0) {
                                        echo '<label class="btn status_btn pb-1" >Active</label> ';
                                        $active_count += 1;
                                    } 
									else {
                                        echo '<label class="btn status_btn2 pb-1" >Onbording</label>';
                                        $onbording_count += 1; 
                                    } 
								?>
							</td>
                            <td><button type="button" location="<?=$value['location']?>" dfr_id="<?=$value['id']?>" req_id="<?=$value['requisition_id']?>" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#example-sub-Modal"><i class="fa fa-eye"></i></button></td>                                                    
                        </tr>
                        <?php $c++; } ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>
                  </div>
    </div>
</div> 

<!-- sub-modal -->

<div class="modal fade table-modal modal-sub" id="example-sub-Modal" role="dialog" >
    <div class="modal-dialog modal-md modal-al">
        <div class="modal-content m-width ">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Title</h4> </div>
            <div class="modal-body" >
                <div class="filter-widget">
                               <table id="datatablesSimple" class="table table-striped ">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Requisition Number</th>
                            <th>Date of Request</th>
                            <th>Location</th>
                            <th>Department</th>
                            <th>Remarks</th>
                            <th>Total Candidate</th>
                            <th>Approve Category</th>
                            <th>Assets Request</th>
                            <th>Requirement Status</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     <tr>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                        <td>Demo</td>
                     </tr>
                    </tbody>
                </table>
                              </div>
            </div>
            <div class="modal-footer">
                        
                          <button type="button" class="btn btn-default default-btn" data-dismiss="modal">Close</button>
                            <button type="button" class=" blue-btn width s-btn">Save</button>
            </div>
       </div>
    </div>
</div>
                  

<script src="<?=base_url()?>assets/css/search-filter/assets/js/scripts.js"></script>
<script src="<?=base_url()?>assets/css/search-filter/assets/js/simple-datatables-latest.js"></script>
<script src="<?=base_url()?>assets/css/search-filter/assets/js/datatables-simple-demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>



<script>
$(function() {
    $('#multiselect').multiselect();
    $('#loaction').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Search for something...'
    });
});
</script>
<!-- Selection Requisition -->
<script>
var xValues = ["Active", "Closed"];
var yValues = [<?=$dfr_count[0]['total_active']?>, <?=$dfr_count[0]['total_closed']?>];
var barColors = ["#4a69bd", "#ff6b81"];
new Chart("mypiechart", {
    type: "pie",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Requisition - Requirement Status"
        }
    }
});
</script>

<!-- Selection Requisition 2 -->
<script>
var xValues = ["Active", "Onbording"];
var yValues = [<?=$active_count?>, <?=$onbording_count?>];
var barColors = ["#05d34e", "#ffa700"];
new Chart("mypiechart2", {
    type: "pie",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Requisition - IT Status"
        }
    }
});
</script>

<!-- Category -->
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("my-doughnut", {
    type: "doughnut",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Total Category"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("my-doughnut1", {
    type: "doughnut",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Category Wise Stock Status"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("mybarchart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "Total Stock of Every Category"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("myBarChart1", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "Category Wise Request List"
        }
    }
});
</script>
<!-- Brand -->
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("brand-doughnut", {
    type: "doughnut",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Total Brand"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("brand-doughnut1", {
    type: "doughnut",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Brand wise Stock Details"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("brand-barchart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "Total Stock of Every Brand"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("brand-BarChart1", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "Brand Wise Request List"
        }
    }
});
</script>
<!-- Inventory Stock -->
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("inventory-doughnut", {
    type: "doughnut",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Total Inventory"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("inventory-doughnut1", {
    type: "doughnut",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Inventory wise Stock Details"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("inventory-barchart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "Total Stock of Every Inventory"
        }
    }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#ff6b81", "#78e08f", "#4a69bd", "#fa983a", "#38ada9"];
new Chart("inventory-BarChart1", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "Inventory Wise Request List"
        }
    }
});
</script>
<!-- new-inventory -->
<script>
var xyValues = [
  {x:50, y:7},
  {x:60, y:8},
  {x:70, y:8},
  {x:80, y:9},
  {x:90, y:9},
  {x:100, y:9},
  {x:110, y:10},
  {x:120, y:11},
  {x:130, y:14},
  {x:140, y:14},
  {x:150, y:15}
];

new Chart("line-chart", {
  type: "scatter",
  data: {
    datasets: [{
      pointRadius: 4,
      pointBackgroundColor: "#0c2461",
      data: xyValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      xAxes: [{ticks: {min: 40, max:160}}],
      yAxes: [{ticks: {min: 6, max:16}}],
    }
  }
});
</script>
<script>
var xValues = [100,200,300,400,500,600,700,800,900,1000];

new Chart("multi-line-chart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{ 
      data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478],
      borderColor: "#e55039",
      fill: false
    }, { 
      data: [1600,1700,1700,1900,2000,2700,4000,5000,6000,7000],
      borderColor: "#079992",
      fill: false
    }, { 
      data: [300,700,2000,5000,6000,4000,2000,1000,200,100],
      borderColor: "#f6b93b",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});
</script>
<script>
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = [
    'rgb(255, 99, 132)',
      'rgb(75, 192, 192)',
      'rgb(255, 205, 86)',
      'rgb(201, 203, 207)',
      'rgb(54, 162, 235)'
];

new Chart("polarArea", {
  type: "polarArea",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "New Chart"
    }
  }
});
</script>
