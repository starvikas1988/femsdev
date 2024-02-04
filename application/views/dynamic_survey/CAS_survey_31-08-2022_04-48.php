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
        <h1>Satisfaction Survey</h1></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="white-box">
        <div class="title">
          <h5>Afin de répondre efficacement à vos besoins et mesurer votre satisfaction par rapport à l’animation déployée durant le mois sacré du Ramadan, nous avons mis en place cette enquête. Toutes les données recueillies restent confidentielles et seront traitées de manière anonyme. Nous vous serions reconnaissants de participer à cette enquête en remplissant ce questionnaire.</h5></div>
        <div class="title">
          <h5>1. Sur une échelle de 1 à 10, quel était votre degré de satisfaction ? </h5></div>
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
            <td><input class="form-check-input" type="radio" required name="56" value="0" id="2_flexRadioDefault_1"></td>
            <td><input class="form-check-input" type="radio" name="56" value="1" id="2_flexRadioDefault_2"></td>
            <td><input class="form-check-input" type="radio" name="56" value="2" id="2_flexRadioDefault_3"></td>
            <td><input class="form-check-input" type="radio" name="56" value="3" id="2_flexRadioDefault_4"></td>
            <td><input class="form-check-input" type="radio" name="56" value="4" id="2_flexRadioDefault_5"></td>
            <td><input class="form-check-input" type="radio" name="56" value="5" id="2_flexRadioDefault_6"></td>
            <td><input class="form-check-input" type="radio" name="56" value="6" id="2_flexRadioDefault_7"></td>
            <td><input class="form-check-input" type="radio" name="56" value="7" id="2_flexRadioDefault_8"></td>
            <td><input class="form-check-input" type="radio" name="56" value="8" id="2_flexRadioDefault_9"></td>
            <td><input class="form-check-input" type="radio" name="56" value="9" id="2_flexRadioDefault_10"></td>
            <td><input class="form-check-input" type="radio" name="56" value="10" id="2_flexRadioDefault_11"></td>
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
        <div class="row">
          <div class="col-md-12">
            <div class="title">
              <!--<h5>IN GENERAL, I AM TREATED FAIRLY REGARDING THE FOLLOWING:</h5> </div>-->
          </div>
          <div class="col-md-12">
            <div class="overflow-scroll label-align">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th>Totalement en Accord</th>
                    <th>En Accord</th>
                    <th>Partiellement d’accord</th>
                    <th>En Désaccord</th>
                    <th>Totalement en Désaccord</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <tr>
                    <td >2. Le contenu de l’animation était-il à la hauteur de vos attentes ?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="Totalement en Accord" name="54" id="48_flexRadioDefault_6" required>
                        <label class="form-check-label" for="48_flexRadioDefault_6">  </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="En Accord" name="54" id="48_flexRadioDefault_5">
                        <label class="form-check-label" for="48_flexRadioDefault_5">  </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="Partiellement d’accord" name="54" id="48_flexRadioDefault_4">
                        <label class="form-check-label" for="48_flexRadioDefault_4">  </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="En Désaccord" name="54" id="48_flexRadioDefault_3">
                        <label class="form-check-label" for="48_flexRadioDefault_3"> </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="Totalement en Désaccord" name="54" id="48_flexRadioDefault_2">
                        <label class="form-check-label" for="48_flexRadioDefault_2">  </label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>3. L'animation vous a-t-elle procuré un moment de détente ?</td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="Totalement en Accord" name="55" id="49_flexRadioDefault_6" required>
                        <label class="form-check-label" for="49_flexRadioDefault_6">  </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="En Accord" name="55" id="49_flexRadioDefault_5">
                        <label class="form-check-label" for="49_flexRadioDefault_5">  </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="Partiellement d’accord" name="55" id="49_flexRadioDefault_4">
                        <label class="form-check-label" for="49_flexRadioDefault_4">  </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="En Désaccord" name="55" id="49_flexRadioDefault_3">
                        <label class="form-check-label" for="49_flexRadioDefault_3">  </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="Totalement en Désaccord" name="55" id="49_flexRadioDefault_2">
                        <label class="form-check-label" for="49_flexRadioDefault_2">  </label>
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
        <div class="title"><h4>4. Quel item, avez-vous le plus apprécié ?</h4></div>
        <div class="form-check term-end">
          <textarea name="57" placeholder="Write here....."></textarea>
        
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