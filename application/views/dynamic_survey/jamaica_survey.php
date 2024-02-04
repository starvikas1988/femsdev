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

/*for navbar end*/
</style>
<div class="container-fluid">
<form method="post" action="<?=base_url()?>dynamic_survey/jam_survey">  
  <div class="row">
    <div class="col-md-12">
      <div class="title">
        <h1>Survey</h1></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="white-box">
        <div class="title">
          <h5>This is a performance evaluation we are doing to your direct team lead or manager, operations staff, and HR Dept. </h5></div>
        <div class="title">
          <h5>Dear employee: This survey is completely anonymous, please feel free to answer the most honest and sincere possible way </h5></div>
        <div class="title">
          <h5>Considering your complete experience with your immediate supervisor, how likely are you to recommend your colleagues to work with him/her? </h5></div>
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <th colspan="5">NOT AT ALL LIKELY</th>
              <th colspan="6" style="text-align: right;">EXTREMELY LIKELY</th>
            </tr>
            <tr>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_1"> 0 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_2"> 1 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_3"> 2 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_4"> 3 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_5"> 4 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_6"> 5 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_7"> 6 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2flexRadioDefault_8"> 7 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_9"> 8 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_10"> 9 </label>
                </div>
              </td>
              <td>
                <div class="form-check">
                  <label class="form-check-label" for="2_flexRadioDefault_11"> 10 </label>
                </div>
              </td>
            </tr>
             <tr>
            <td><input class="form-check-input" type="radio" required name="2" value="0" id="2_flexRadioDefault_1"></td>
            <td><input class="form-check-input" type="radio" name="2" value="1" id="2_flexRadioDefault_2"></td>
            <td><input class="form-check-input" type="radio" name="2" value="2" id="2_flexRadioDefault_3"></td>
            <td><input class="form-check-input" type="radio" name="2" value="3" id="2_flexRadioDefault_4"></td>
            <td><input class="form-check-input" type="radio" name="2" value="4" id="2_flexRadioDefault_5"></td>
            <td><input class="form-check-input" type="radio" name="2" value="5" id="2_flexRadioDefault_6"></td>
            <td><input class="form-check-input" type="radio" name="2" value="6" id="2_flexRadioDefault_7"></td>
            <td><input class="form-check-input" type="radio" name="2" value="7" id="2_flexRadioDefault_8"></td>
            <td><input class="form-check-input" type="radio" name="2" value="8" id="2_flexRadioDefault_9"></td>
            <td><input class="form-check-input" type="radio" name="2" value="9" id="2_flexRadioDefault_10"></td>
            <td><input class="form-check-input" type="radio" name="2" value="10" id="2_flexRadioDefault_11"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-4">
      <div class="white-box" style="height: 242px;">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>How long have you been associated with the organization?</h5></div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Less than 6 month" name="1" id="1_flexRadioDefault_1" required>
              <label class="form-check-label" for="1_flexRadioDefault_1"> Less than 6 month </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="6 months- 1 year" name="1" id="1_flexRadioDefault_2">
              <label class="form-check-label" for="1_flexRadioDefault_2"> 6 months- 1 year </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="1 year-5 years" name="1" id="1_flexRadioDefault_3">
              <label class="form-check-label" for="1_flexRadioDefault_3"> 1 year-5 years </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="5-10 years" name="1" id="1_flexRadioDefault_4">
              <label class="form-check-label" for="1_flexRadioDefault_4"> 5-10 years </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Above 10 years" name="1" id="1_flexRadioDefault_5">
              <label class="form-check-label" for="1_flexRadioDefault_5"> Above 10 years </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="white-box">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>What do you feel about the following statements?</h5></div>
          </div>
          <div class="col-md-12">
            <div class="overflow-scroll">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="width:50%;"></th>
                    <th>Strongly Disagree </th>
                    <th>Disagree </th>
                    <th>Neutral </th>
                    <th>Agree </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1. My immediate supervisor is impartial</td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="3" id="3_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="3" id="3_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="3" id="3_flexRadioDefault_4">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="3" id="3_flexRadioDefault_5">
                    </td>
                  </tr>
                  <tr>
                    <td>2. My immediate supervisor follows through on commitments </td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="4" id="4_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="4" id="4_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="4" id="4_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="4" id="4_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>3. My immediate supervisor gives me feedback that helps me improve my work </td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="5" id="5_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="5" id="5_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="5" id="5_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="5" id="5_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>4. I receive coaching and training from my immediate supervisor</td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="6" id="6_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="6" id="6_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="6" id="6_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="6" id="6_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>5. My immediate supervisor is always available for quick discussions </td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="7" id="7_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="7" id="7_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="7" id="7_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="7" id="7_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>6. I receive recognition from my immediate supervisor </td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="8" id="8_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="8" id="8_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="8" id="8_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="8" id="8_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>7. I feel my performance is fairly evaluated </td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="9" id="9_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="9" id="9_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="9" id="9_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="9" id="9_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>8. My immediate supervisor is open to feedback</td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="10" id="10_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="10" id="10_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="10" id="10_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="10" id="10_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>9. My supervisor has a vision for my progress</td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="11" id="11_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="11" id="11_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="11" id="11_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="11" id="11_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>10. My manager helps me achieve my personal goals</td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="12" id="12_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="12" id="12_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="12" id="12_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="12" id="12_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>11. My team leader helps me align my personal goals with organizational goals </td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="13" id="13_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="13" id="13_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="13" id="13_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="13" id="13_flexRadioDefault_4">
                    </td>
                  </tr>
                  <tr>
                    <td>12. My superior conducts regular meetings to evaluate my performance and give feedback to improve it</td>
                    <td>
                      <input class="form-check-input" type="radio" value="1" name="14" id="14_flexRadioDefault_1" required>
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="2" name="14" id="14_flexRadioDefault_2">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="3" name="14" id="14_flexRadioDefault_3">
                    </td>
                    <td>
                      <input class="form-check-input" type="radio" value="4" name="14" id="14_flexRadioDefault_4">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--2-->
  <div class="row">
    <div class="col-md-4">
      <div class="white-box" style="height: 192px;">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>Overall, how satisfied are you with the job being done by your immediate supervisor?</h5></div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Very dissatisfied" name="16" id="16_flexRadioDefault_1" required>
              <label class="form-check-label" for="16_flexRadioDefault_1"> Very dissatisfied </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Not satisfied" name="16" id="16_flexRadioDefault_2">
              <label class="form-check-label" for="16_flexRadioDefault_2"> Not satisfied </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Neutral" name="16" id="16_flexRadioDefault_3">
              <label class="form-check-label" for="16_flexRadioDefault_3"> Neutral </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Satisfied" name="16" id="16_flexRadioDefault_4">
              <label class="form-check-label" for="16_flexRadioDefault_4"> Satisfied </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="white-box">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>How often does your manager give feedback on your work?</h5></div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Never" name="17" id="17_flexRadioDefault_1" required>
              <label class="form-check-label" for="17_flexRadioDefault_1"> Never </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Monthly" name="17" id="17_flexRadioDefault_2">
              <label class="form-check-label" for="17_flexRadioDefault_2"> Monthly </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Quarterly" name="17" id="17_flexRadioDefault_3">
              <label class="form-check-label" for="17_flexRadioDefault_3"> Quarterly </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Half yearly" name="17" id="17_flexRadioDefault_4">
              <label class="form-check-label" for="17_flexRadioDefault_4"> Half yearly </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Yearly" name="17" id="17_flexRadioDefault_5">
              <label class="form-check-label" for="17_flexRadioDefault_5"> Yearly </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="white-box">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>How helpful has been the feedback given by your manager?</h5></div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Not at all helpful" name="18" id="18_flexRadioDefault_1" required>
              <label class="form-check-label" for="18_flexRadioDefault_1"> Not at all helpful </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Slightly helpful" name="18" id="18_flexRadioDefault_2">
              <label class="form-check-label" for="18_flexRadioDefault_2"> Slightly helpful </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Moderately helpful" name="18" id="18_flexRadioDefault_3">
              <label class="form-check-label" for="18_flexRadioDefault_3"> Moderately helpful </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Very helpful" name="18" id="18_flexRadioDefault_4">
              <label class="form-check-label" for="18_flexRadioDefault_4"> Very helpful </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Extremely helpful" name="18" id="18_flexRadioDefault_5">
              <label class="form-check-label" for="18_flexRadioDefault_5"> Extremely helpful </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--3-->
  <div class="row">
    <div class="col-md-4">
      <div class="white-box">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>If you have ever offered suggestions to the management, how satisfied were you with the response? </h5></div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Very dissatisfied" name="19" id="19_flexRadioDefault_1" required>
              <label class="form-check-label" for="19_flexRadioDefault_1"> Very dissatisfied </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Not satisfied" name="19" id="19_flexRadioDefault_2">
              <label class="form-check-label" for="19_flexRadioDefault_2"> Not satisfied </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Neutral" name="19" id="19_flexRadioDefault_3">
              <label class="form-check-label" for="19_flexRadioDefault_3"> Neutral </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Satisfied" name="19" id="19_flexRadioDefault_4">
              <label class="form-check-label" for="19_flexRadioDefault_4"> Satisfied </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Very Satisfied" name="19" id="19_flexRadioDefault_5">
              <label class="form-check-label" for="19_flexRadioDefault_5"> Very Satisfied </label>
            </div>            
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="white-box"style="height: 207px;">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>How well does your manager respond to your mistakes?</h5></div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Extremely well" name="20" id="20_flexRadioDefault_1" required>
              <label class="form-check-label" for="20_flexRadioDefault_1"> Extremely well </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Very well" name="20" id="20_flexRadioDefault_2">
              <label class="form-check-label" for="20_flexRadioDefault_2"> Very well </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Moderately well" name="20" id="20_flexRadioDefault_3">
              <label class="form-check-label" for="20_flexRadioDefault_3"> Moderately well </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Slightly well" name="20" id="20_flexRadioDefault_4">
              <label class="form-check-label" for="20_flexRadioDefault_4"> Slightly well </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Not at all" name="20" id="20_flexRadioDefault_5">
              <label class="form-check-label" for="20_flexRadioDefault_5"> Not at all </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="white-box"style="height: 206px;">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>Do you think your good work gets rewarded?</div>
     </div>
      <div class="col-md-4" >
      <div class="form-check">
        <input class="form-check-input" type="radio" value="Yes" name="21" id="21_flexRadioDefault_1" required>
        <label class="form-check-label" for="21_flexRadioDefault_1">
        Yes 
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" value="No" name="21" id="21_flexRadioDefault_2">
        <label class="form-check-label" for="21_flexRadioDefault_2">
        No
        </label>
      </div>

      
       
     </div>
   </div>
   </div>
   </div>
   </div>
   <div class="row">
   <div class="col-md-12">
       
    <div class="white-box">
        <div class="title"><h4> Do you have any comments, concerns or suggestions for your supervisor? (REMEMBER! THIS IS ANONYMOUS)</h4></div>
        <div class="form-check term-end">
          <textarea name="22" placeholder="Write here......."></textarea>
        
        </div>
      </div>        
  </div>
  </div>
     <!--3-->
     <div class="row">
    <div class="col-md-6">
   <div class="white-box">
   <div class="row">
      <div class="col-md-12" >
       <div class="title"> <h5>INTERACTIONS WITH HR</h5></div>
          </div>
          <div class="col-md-12">
            <div class="overflow-scroll">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Strongly Agree</th>
                    <th>Agree</th>
                    <th>Neutral</th>
                    <th>Disagree&nbsp;</th>
                    <th>Strongly Disagree</th>
                    <th>Don't Know</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="6">I have good access to HR employees for advice and assistance. </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="23" id="23_flexRadioDefault_6" required>
                        <label class="form-check-label" for="23_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="23" id="23_flexRadioDefault_5">
                        <label class="form-check-label" for="23_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="23" id="23_flexRadioDefault_4">
                        <label class="form-check-label" for="23_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="23" id="23_flexRadioDefault_3">
                        <label class="form-check-label" for="23_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="23" id="23_flexRadioDefault_2">
                        <label class="form-check-label" for="23_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="23" id="23_flexRadioDefault_1">
                        <label class="form-check-label" for="23_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">When I contact my HR department, I usually receive help in a timely manner.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="24" id="24_flexRadioDefault_6" required>
                        <label class="form-check-label" for="24_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="24" id="24_flexRadioDefault_5">
                        <label class="form-check-label" for="24_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="24" id="24_flexRadioDefault_4">
                        <label class="form-check-label" for="24_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="24" id="24_flexRadioDefault_3">
                        <label class="form-check-label" for="24_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="24" id="24_flexRadioDefault_2">
                        <label class="form-check-label" for="24_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="24" id="24_flexRadioDefault_1">
                        <label class="form-check-label" for="24_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">Getting HR information is more difficult than&nbsp;it should be because of a lack of sufficient skill amongst the HR staff.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="25" id="25_flexRadioDefault_6" required>
                        <label class="form-check-label" for="25_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="25" id="25_flexRadioDefault_5">
                        <label class="form-check-label" for="25_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="25" id="25_flexRadioDefault_4">
                        <label class="form-check-label" for="25_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="25" id="25_flexRadioDefault_3">
                        <label class="form-check-label" for="25_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="25" id="25_flexRadioDefault_2">
                        <label class="form-check-label" for="25_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="25" id="25_flexRadioDefault_1">
                        <label class="form-check-label" for="25_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">Getting HR information is more difficult than&nbsp;it should be because of a lack of sufficient staff resources in the HR department.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="26" id="26_flexRadioDefault_6" required>
                        <label class="form-check-label" for="26_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="26" id="26_flexRadioDefault_5">
                        <label class="form-check-label" for="26_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="26" id="26_flexRadioDefault_4">
                        <label class="form-check-label" for="26_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="26" id="26_flexRadioDefault_3">
                        <label class="form-check-label" for="26_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="26" id="26_flexRadioDefault_2">
                        <label class="form-check-label" for="26_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="26" id="26_flexRadioDefault_1">
                        <label class="form-check-label" for="26_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">I am able to access to the right person in the HR department to get the information or service I&nbsp;need.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="27" id="27_flexRadioDefault_6" required>
                        <label class="form-check-label" for="27_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="27" id="27_flexRadioDefault_5">
                        <label class="form-check-label" for="27_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="27" id="27_flexRadioDefault_4">
                        <label class="form-check-label" for="27_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="27" id="27_flexRadioDefault_3">
                        <label class="form-check-label" for="27_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="27" id="27_flexRadioDefault_2">
                        <label class="form-check-label" for="27_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="27" id="27_flexRadioDefault_1">
                        <label class="form-check-label" for="27_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">The&nbsp;HR department makes&nbsp;sincere attempts to&nbsp;answer my&nbsp;questions or assist with problems.&nbsp; </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="28" id="28_flexRadioDefault_6" required>
                        <label class="form-check-label" for="28_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="28" id="28_flexRadioDefault_5">
                        <label class="form-check-label" for="28_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="28" id="28_flexRadioDefault_4">
                        <label class="form-check-label" for="28_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="28" id="28_flexRadioDefault_3">
                        <label class="form-check-label" for="28_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="28" id="28_flexRadioDefault_2">
                        <label class="form-check-label" for="28_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="28" id="28_flexRadioDefault_1">
                        <label class="form-check-label" for="28_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="white-box" style="height: 511px;">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>OVERALL QUALITY OF SERVICE FROM YOUR HR DEPARTMENT</h5> 

            </div>
            <p class="title">Please base your answers on actual experiences you have had with the HR department; do not base your answers on hearsay. If you believe you do not have enough information about a particular service or you have not had first-hand experience with the service, select the "do not know" response.</p>
          </div>
          <div class="col-md-12">
            <div class="overflow-scroll label-align">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Strongly Agree</th>
                    <th>Agree</th>
                    <th>Neutral</th>
                    <th>Disagree&nbsp;</th>
                    <th>Strongly Disagree</th>
                    <th>Don't Know</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="6">Timeliness - information or assistance is provided promptly.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="29" id="29_flexRadioDefault_6" required>
                        <label class="form-check-label" for="29_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="29" id="29_flexRadioDefault_5">
                        <label class="form-check-label" for="29_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="29" id="29_flexRadioDefault_4">
                        <label class="form-check-label" for="29_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="29" id="29_flexRadioDefault_3">
                        <label class="form-check-label" for="29_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="29" id="29_flexRadioDefault_2">
                        <label class="form-check-label" for="29_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="29" id="29_flexRadioDefault_1">
                        <label class="form-check-label" for="29_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">Clarity - information or assistance is provided in a clear manner and is easy to understand.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="30" id="30_flexRadioDefault_6" required>
                        <label class="form-check-label" for="30_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="30" id="30_flexRadioDefault_5">
                        <label class="form-check-label" for="30_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="30" id="30_flexRadioDefault_4">
                        <label class="form-check-label" for="30_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="30" id="30_flexRadioDefault_3">
                        <label class="form-check-label" for="30_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="30" id="30_flexRadioDefault_2">
                        <label class="form-check-label" for="30_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="30" id="30_flexRadioDefault_1">
                        <label class="form-check-label" for="30_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">Accuracy - information or assistance provided is current and accurate.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="31" id="31_flexRadioDefault_6" required>
                        <label class="form-check-label" for="31_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="31" id="31_flexRadioDefault_5">
                        <label class="form-check-label" for="31_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="31" id="31_flexRadioDefault_4">
                        <label class="form-check-label" for="31_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="31" id="31_flexRadioDefault_3">
                        <label class="form-check-label" for="31_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="31" id="31_flexRadioDefault_2">
                        <label class="form-check-label" for="31_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="31" id="31_flexRadioDefault_1">
                        <label class="form-check-label" for="31_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">Manner - information or assistance is provided in a courteous manner with a good attitude.</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="32" id="32_flexRadioDefault_6" required>
                        <label class="form-check-label" for="32_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="32" id="32_flexRadioDefault_5">
                        <label class="form-check-label" for="32_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="32" id="32_flexRadioDefault_4">
                        <label class="form-check-label" for="32_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="32" id="32_flexRadioDefault_3">
                        <label class="form-check-label" for="32_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="32" id="32_flexRadioDefault_2">
                        <label class="form-check-label" for="32_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="32" id="32_flexRadioDefault_1">
                        <label class="form-check-label" for="32_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--3-->
  <div class="row">
    <div class="col-md-12">
      <div class="white-box">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>PLEASE INDICATE THE EXTENT TO WHICH YOU AGREE OR DISAGREE WITH THE FOLLOWING STATEMENTS: </h5></div>
          </div>
          <div class="col-md-12">
            <div class="overflow-scroll label-align">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="width:50%;"></th>
                    <th>Strongly Agree</th>
                    <th>Agree</th>
                    <th>Neutral</th>
                    <th>Disagree&nbsp;</th>
                    <th>Strongly Disagree</th>
                    <th>Don't Know</th>
                  </tr>
                </thead>
                <tbody>
                 
                  <tr>
                    <td>1.I am promptly informed about important changes in HR rules or benefits</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="33" id="33_flexRadioDefault_6" required>
                        <label class="form-check-label" for="33_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="33" id="33_flexRadioDefault_5">
                        <label class="form-check-label" for="33_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="33" id="33_flexRadioDefault_4">
                        <label class="form-check-label" for="33_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="33" id="33_flexRadioDefault_3">
                        <label class="form-check-label" for="33_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="33" id="33_flexRadioDefault_2">
                        <label class="form-check-label" for="33_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="33" id="33_flexRadioDefault_1">
                        <label class="form-check-label" for="33_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                  <td >2.Policies and procedures affecting my work are communicated adequately.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="34" id="34_flexRadioDefault_6" required>
                        <label class="form-check-label" for="34_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="34" id="34_flexRadioDefault_5">
                        <label class="form-check-label" for="34_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="34" id="34_flexRadioDefault_4">
                        <label class="form-check-label" for="34_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="34" id="34_flexRadioDefault_3">
                        <label class="form-check-label" for="34_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="34" id="34_flexRadioDefault_2">
                        <label class="form-check-label" for="34_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="34" id="34_flexRadioDefault_1">
                        <label class="form-check-label" for="34_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>3.Awards and recognition are given to the most deserving employees.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="35" id="35_flexRadioDefault_6" required>
                        <label class="form-check-label" for="35_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="35" id="35_flexRadioDefault_5">
                        <label class="form-check-label" for="35_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="35" id="35_flexRadioDefault_4">
                        <label class="form-check-label" for="35_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="35" id="35_flexRadioDefault_3">
                        <label class="form-check-label" for="35_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="35" id="35_flexRadioDefault_2">
                        <label class="form-check-label" for="35_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="35" id="35_flexRadioDefault_1">
                        <label class="form-check-label" for="35_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td >4.I get the training I need to do my job effectively.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="36" id="36_flexRadioDefault_6" required>
                        <label class="form-check-label" for="36_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="36" id="36_flexRadioDefault_5">
                        <label class="form-check-label" for="36_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="36" id="36_flexRadioDefault_4">
                        <label class="form-check-label" for="36_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="36" id="36_flexRadioDefault_3">
                        <label class="form-check-label" for="36_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="36" id="36_flexRadioDefault_2">
                        <label class="form-check-label" for="36_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="36" id="36_flexRadioDefault_1">
                        <label class="form-check-label" for="36_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>5.I understand the mission and functions of my immediate work area.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="37" id="37_flexRadioDefault_6" required>
                        <label class="form-check-label" for="37_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="37" id="37_flexRadioDefault_5">
                        <label class="form-check-label" for="37_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="37" id="37_flexRadioDefault_4">
                        <label class="form-check-label" for="37_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="37" id="37_flexRadioDefault_3">
                        <label class="form-check-label" for="37_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="37" id="37_flexRadioDefault_2">
                        <label class="form-check-label" for="37_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="37" id="37_flexRadioDefault_1">
                        <label class="form-check-label" for="37_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td >6.The organizational structure of my area makes it easy to focus on quality.&nbsp; </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="38" id="38_flexRadioDefault_6" required>
                        <label class="form-check-label" for="38_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="38" id="38_flexRadioDefault_5">
                        <label class="form-check-label" for="38_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="38" id="38_flexRadioDefault_4">
                        <label class="form-check-label" for="38_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="38" id="38_flexRadioDefault_3">
                        <label class="form-check-label" for="38_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="38" id="38_flexRadioDefault_2">
                        <label class="form-check-label" for="38_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="38" id="38_flexRadioDefault_1">
                        <label class="form-check-label" for="38_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>7.I have all the skills needed to do my job well.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="39" id="39_flexRadioDefault_6" required>
                        <label class="form-check-label" for="39_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="39" id="39_flexRadioDefault_5">
                        <label class="form-check-label" for="39_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="39" id="39_flexRadioDefault_4">
                        <label class="form-check-label" for="39_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="39" id="39_flexRadioDefault_3">
                        <label class="form-check-label" for="39_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="39" id="39_flexRadioDefault_2">
                        <label class="form-check-label" for="39_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="39" id="39_flexRadioDefault_1">
                        <label class="form-check-label" for="39_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>8.I would recommend that others pursue a job opportunity at this company.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="40" id="40_flexRadioDefault_6" required>
                        <label class="form-check-label" for="40_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="40" id="40_flexRadioDefault_5">
                        <label class="form-check-label" for="40_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="40" id="40_flexRadioDefault_4">
                        <label class="form-check-label" for="40_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="40" id="40_flexRadioDefault_3">
                        <label class="form-check-label" for="40_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="40" id="40_flexRadioDefault_2">
                        <label class="form-check-label" for="40_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="40" id="40_flexRadioDefault_1">
                        <label class="form-check-label" for="40_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>9.Organizational structure in my area facilitates communication with employees.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="41" id="41_flexRadioDefault_6" required>
                        <label class="form-check-label" for="41_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="41" id="41_flexRadioDefault_5">
                        <label class="form-check-label" for="41_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="41" id="41_flexRadioDefault_4">
                        <label class="form-check-label" for="41_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="41" id="41_flexRadioDefault_3">
                        <label class="form-check-label" for="41_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="41" id="41_flexRadioDefault_2">
                        <label class="form-check-label" for="41_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="41" id="41_flexRadioDefault_1">
                        <label class="form-check-label" for="41_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>10.My performance standards are clear.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="42" id="42_flexRadioDefault_6" required>
                        <label class="form-check-label" for="42_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="42" id="42_flexRadioDefault_5">
                        <label class="form-check-label" for="42_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="42" id="42_flexRadioDefault_4">
                        <label class="form-check-label" for="42_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="42" id="42_flexRadioDefault_3">
                        <label class="form-check-label" for="42_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="42" id="42_flexRadioDefault_2">
                        <label class="form-check-label" for="42_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="42" id="42_flexRadioDefault_1">
                        <label class="form-check-label" for="42_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>11.My performance standards are realistic.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="43" id="43_flexRadioDefault_6" required>
                        <label class="form-check-label" for="43_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="43" id="43_flexRadioDefault_5">
                        <label class="form-check-label" for="43_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="43" id="43_flexRadioDefault_4">
                        <label class="form-check-label" for="43_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="43" id="43_flexRadioDefault_3">
                        <label class="form-check-label" for="43_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="43" id="43_flexRadioDefault_2">
                        <label class="form-check-label" for="43_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="43" id="43_flexRadioDefault_1">
                        <label class="form-check-label" for="43_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                     <td>12.My department is able to attract high-quality employees.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="44" id="44_flexRadioDefault_6" required>
                        <label class="form-check-label" for="44_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="44" id="44_flexRadioDefault_5">
                        <label class="form-check-label" for="44_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="44" id="44_flexRadioDefault_4">
                        <label class="form-check-label" for="44_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="44" id="44_flexRadioDefault_3">
                        <label class="form-check-label" for="44_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="44" id="44_flexRadioDefault_2">
                        <label class="form-check-label" for="44_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="44" id="44_flexRadioDefault_1">
                        <label class="form-check-label" for="44_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                     <td >13.I am encouraged to participate in cultural awareness observances.&nbsp;</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="45" id="45_flexRadioDefault_6" required>
                        <label class="form-check-label" for="45_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="45" id="45_flexRadioDefault_5">
                        <label class="form-check-label" for="45_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="45" id="45_flexRadioDefault_4">
                        <label class="form-check-label" for="45_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="45" id="45_flexRadioDefault_3">
                        <label class="form-check-label" for="45_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="45" id="45_flexRadioDefault_2">
                        <label class="form-check-label" for="45_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="45" id="45_flexRadioDefault_1">
                        <label class="form-check-label" for="45_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td>14.The morale in my work area is good.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="46" id="46_flexRadioDefault_6" required>
                        <label class="form-check-label" for="46_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="46" id="46_flexRadioDefault_5">
                        <label class="form-check-label" for="46_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="46" id="46_flexRadioDefault_4">
                        <label class="form-check-label" for="46_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="46" id="46_flexRadioDefault_3">
                        <label class="form-check-label" for="46_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="46" id="46_flexRadioDefault_2">
                        <label class="form-check-label" for="46_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="46" id="46_flexRadioDefault_1">
                        <label class="form-check-label" for="46_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td >15.The overall morale in the company is good.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="47" id="47_flexRadioDefault_6" required>
                        <label class="form-check-label" for="47_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="47" id="47_flexRadioDefault_5">
                        <label class="form-check-label" for="47_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="47" id="47_flexRadioDefault_4">
                        <label class="form-check-label" for="47_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="47" id="47_flexRadioDefault_3">
                        <label class="form-check-label" for="47_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="47" id="47_flexRadioDefault_2">
                        <label class="form-check-label" for="47_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="47" id="47_flexRadioDefault_1">
                        <label class="form-check-label" for="47_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="white-box">
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <h5>IN GENERAL, I AM TREATED FAIRLY REGARDING THE FOLLOWING:</h5> </div>
          </div>
          <div class="col-md-12">
            <div class="overflow-scroll label-align">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th>Strongly Agree</th>
                    <th>Agree</th>
                    <th>Neutral</th>
                    <th>Disagree&nbsp;</th>
                    <th>Strongly Disagree</th>
                    <th>Don't Know</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <tr>
                    <td >1.Promotions.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="48" id="48_flexRadioDefault_6" required>
                        <label class="form-check-label" for="48_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="48" id="48_flexRadioDefault_5">
                        <label class="form-check-label" for="48_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="48" id="48_flexRadioDefault_4">
                        <label class="form-check-label" for="48_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="48" id="48_flexRadioDefault_3">
                        <label class="form-check-label" for="48_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="48" id="48_flexRadioDefault_2">
                        <label class="form-check-label" for="48_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="48" id="48_flexRadioDefault_1">
                        <label class="form-check-label" for="48_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>2.Training.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="49" id="49_flexRadioDefault_6" required>
                        <label class="form-check-label" for="49_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="49" id="49_flexRadioDefault_5">
                        <label class="form-check-label" for="49_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="49" id="49_flexRadioDefault_4">
                        <label class="form-check-label" for="49_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="49" id="49_flexRadioDefault_3">
                        <label class="form-check-label" for="49_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="49" id="49_flexRadioDefault_2">
                        <label class="form-check-label" for="49_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="49" id="49_flexRadioDefault_1">
                        <label class="form-check-label" for="49_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>3.Awards.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="50" id="50_flexRadioDefault_6" required>
                        <label class="form-check-label" for="50_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="50" id="50_flexRadioDefault_5">
                        <label class="form-check-label" for="50_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="50" id="50_flexRadioDefault_4">
                        <label class="form-check-label" for="50_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="50" id="50_flexRadioDefault_3">
                        <label class="form-check-label" for="50_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="50" id="50_flexRadioDefault_2">
                        <label class="form-check-label" for="50_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="50" id="50_flexRadioDefault_1">
                        <label class="form-check-label" for="50_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>4.Discipline.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="51" id="51_flexRadioDefault_6" required>
                        <label class="form-check-label" for="51_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="51" id="51_flexRadioDefault_5">
                        <label class="form-check-label" for="51_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="51" id="51_flexRadioDefault_4">
                        <label class="form-check-label" for="51_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="51" id="51_flexRadioDefault_3">
                        <label class="form-check-label" for="51_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="51" id="51_flexRadioDefault_2">
                        <label class="form-check-label" for="51_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="51" id="51_flexRadioDefault_1">
                        <label class="form-check-label" for="51_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td >5.Performance appraisal.</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="5" name="52" id="52_flexRadioDefault_6" required>
                        <label class="form-check-label" for="52_flexRadioDefault_6"> 5 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="4" name="52" id="52_flexRadioDefault_5">
                        <label class="form-check-label" for="52_flexRadioDefault_5"> 4 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="52" id="52_flexRadioDefault_4">
                        <label class="form-check-label" for="52_flexRadioDefault_4"> 3 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="52" id="52_flexRadioDefault_3">
                        <label class="form-check-label" for="52_flexRadioDefault_3"> 2 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="52" id="52_flexRadioDefault_2">
                        <label class="form-check-label" for="52_flexRadioDefault_2"> 1 </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="52" id="52_flexRadioDefault_1">
                        <label class="form-check-label" for="52_flexRadioDefault_1"> 0 </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <div class="white-box">
        <div class="title"><h4>Please provide any additional comments regarding your experiences with the HR department:</h4></div>
        <div class="form-check term-end">
          <textarea name="53" placeholder="Write here....."></textarea>
        
        </div>
      </div>
    </div>
  </div>
  <div class="btn">
    <button type="submit" class="btn blue-btn">Submit</button>
    <a href="<?=base_url()?>home/dynamic_survey_skip" style="background-color: red;color: white;" class="btn  btn-default">Skip Now</a>
  </div>
</form>
</div>