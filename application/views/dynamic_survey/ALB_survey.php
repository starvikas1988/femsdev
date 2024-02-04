<style>
* {
  margin: 0;
  box-sizing: border-box;
}

body {
  font-family: "Roboto", sans-serif;
  background: #ecf0f1;
  color: #2c3e50;
}

.title {
  margin: 16px 0;
  border-left: 5px solid #e74c3c;
  padding-left: 16px;
}

.container .group {
  padding: 8px 48px;
  margin: 8px;
}

.white-box {
  background: #fff;
  border: 1px solid #1d40ca;
  margin: 10px 5px 10px 5px;
  padding: 10px;
  border-radius: 5px;
}

label {
  display: inline-block;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: 500;
  font-size: 12px;
}

.btn {
  width: 200px;
  border-radius: 20px;
  font-size: 14px;
  padding: 8px;
}

.blue-btn {
  margin: .5em;
  font-size: 1em;
  text-transform: capitalize;
  background-color: #4650dd;
  color: white;
  border: none;
  padding: 8px;
  border-radius: 20px;
}

.blue-btn:hover {
  background-color: #1725eb;
  color: #fff;
}

.blue-btn:focus {
  background-color: #1725eb;
  color: #fff;
}

.term-end label {
  font-weight: 700;
  font-size: 13px;
}


/*table scroll*/


/*.overflow-scroll{
overflow-y: scroll;
height: 123px;
}*/


/*for navbar start*/

body.sb-left .app-navbar {
  left: 0px;
  margin-left: 0px;
}

body.sb-left .app-main {
  margin-left: 0px;
}

.hamburger-box {
  display: none;
}
.label-align .form-check-label{
position: relative;
top: -1px;
}
.new-head{
  display: flex;
  /*justify-content: center;*/
  font-size: 20px;
height: 44px;

}
.new-table .form-check-input{
  cursor: pointer;
  accent-color: #0c4ff2;
}
/*for navbar end*/
</style>
<div class="container-fluid">
<form method="post" action="<?=base_url()?>dynamic_survey/jam_survey">
  <div class="row">
    <div class="col-md-12">
      <div class="title">
        <h1>Satisfaction Survey</h1></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="white-box">
        <div class="title">
          <h5>Please complete this short survey to let us know how satisfied you are with your overall experience at our Company. All responses are recorded anonymously so feel free to provide honest feedback. Your responses will help us improve our services. </h5></div>

              <table class="table table-striped table-bordered new-table">
                <thead>
                  <tr>
                    <th rowspan="2" ><span class="new-head">Questions</span></th>
                    <th colspan="12"><span>NOT AT ALL LIKELY</span><span style="float:right;">EXTREMELY LIKELY</span></th>
                    
                  </tr>
                  <tr>
                   
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <tr>
                    <td style="width:550px;">1. Do you enjoy our company’s culture?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="59" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="59">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="59">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >2. Do you feel connected to your coworkers?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="60" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="60">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="60">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >3. Do you feel valued for your contributions?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="61" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="61">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="61">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >4. Does your team provide you support at work whenever needed?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="62" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="62">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="62">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >5. How transparent do you feel the management is?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="63" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="63">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="63">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >6. Do you think that work is distributed evenly across your team? </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="64" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="64">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="64">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >7. Do you think the management respects your personal family time?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="65" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="65">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="65">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >8. Does your job cause you an unreasonable amount of stress?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="66" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="66">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="66">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >9. If you resigned tomorrow, why would that be?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="67" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="67">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="67">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >10. If something unusual comes up, do you know who to go for a solution?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="68" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="68">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="68">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >11. Do you feel as though your job responsibilities are clearly defined?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="69" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="69">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="69">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >12. Do you feel you are rewarded for your dedication and commitment towards the work?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="70" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="70">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="70">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >13. Do you think the management respects your personal family time?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="71" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="71">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="71">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >14. Does your manager praise you when you have done a good job?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="72" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="72">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="72">
                      </div>
                    </td>                                                                                            
                  </tr>

                  <tr>
                    <td >15. How happy are you at work?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="73" required>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="6" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="7" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="9" name="73">
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="10" name="73">
                      </div>
                    </td>                                                                                            
                  </tr>
      
                </tbody>
              </table>
      </div>
    </div>
  </div>
  <!--3-->
     <!--3-->
  <div class="row">
    <div class="col-md-12">
    <div class="white-box">
        <div class="title"><h4>16. Remarks</h4></div>
        <div class="form-check term-end">
          <textarea name="74" placeholder="Write here....."></textarea>
        
        </div>
      </div>
    </div>
  </div>  
  <div class="btn">
    <button type="submit" class="btn blue-btn">Submit</button>
      <?php if (get_user_fusion_id() == "FKOL000001" || get_user_fusion_id() == "FKOL008610" || get_user_fusion_id() == "FKOL011103") { ?>
    <a href="<?=base_url()?>home/dynamic_survey_skip" style="background-color: red;color: white;" class="btn  btn-default">Skip Now</a>
    <?php } ?>
  </div>
</form>
</div>