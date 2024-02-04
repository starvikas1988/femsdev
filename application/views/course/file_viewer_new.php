<link rel="stylesheet" href="<?php echo base_url();?>course_uploads/85/shim.css">
<link type="text/css" href="<?php echo base_url();?>course_uploads/85/entry-main-legacy.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>course_uploads/85/udlite-common-css.css">

<style>/* cyrillic-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 300;
    src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OX-hpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhv.woff) format('woff');
    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
}
/* cyrillic */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 300;
    src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OVuhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhv.woff) format('woff');
    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
}
/* greek-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 300;
    src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXuhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhv.woff) format('woff');
    unicode-range: U+1F00-1FFF;
}
/* greek */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 300;
    src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OUehpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhv.woff) format('woff');
    unicode-range: U+0370-03FF;
}
/* vietnamese */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 300;
    src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXehpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhv.woff) format('woff');
    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 300;
    src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhv.woff) format('woff');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 300;
    src: local('Open Sans Light'), local('OpenSans-Light'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OUuhpKKSTjw.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN_r8OXOhv.woff) format('woff');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* cyrillic-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFWJ0bf8pkAp6a.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50d.woff) format('woff');
    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
}
/* cyrillic */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFUZ0bf8pkAp6a.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50d.woff) format('woff');
    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
}
/* greek-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFWZ0bf8pkAp6a.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50d.woff) format('woff');
    unicode-range: U+1F00-1FFF;
}
/* greek */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFVp0bf8pkAp6a.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50d.woff) format('woff');
    unicode-range: U+0370-03FF;
}
/* vietnamese */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFWp0bf8pkAp6a.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50d.woff) format('woff');
    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50bf8pkAp6a.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50d.woff) format('woff');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFVZ0bf8pkAg.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50d.woff) format('woff');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* cyrillic-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 600;
    src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOX-hpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhv.woff) format('woff');
    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
}
/* cyrillic */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 600;
    src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOVuhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhv.woff) format('woff');
    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
}
/* greek-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 600;
    src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXuhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhv.woff) format('woff');
    unicode-range: U+1F00-1FFF;
}
/* greek */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 600;
    src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOUehpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhv.woff) format('woff');
    unicode-range: U+0370-03FF;
}
/* vietnamese */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 600;
    src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXehpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhv.woff) format('woff');
    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 600;
    src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhv.woff) format('woff');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 600;
    src: local('Open Sans SemiBold'), local('OpenSans-SemiBold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOUuhpKKSTjw.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UNirkOXOhv.woff) format('woff');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* cyrillic-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOX-hpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhv.woff) format('woff');
    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
}
/* cyrillic */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOVuhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhv.woff) format('woff');
    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
}
/* greek-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXuhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhv.woff) format('woff');
    unicode-range: U+1F00-1FFF;
}
/* greek */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOUehpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhv.woff) format('woff');
    unicode-range: U+0370-03FF;
}
/* vietnamese */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXehpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhv.woff) format('woff');
    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhpKKSTj5PW.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhv.woff) format('woff');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-display: fallback;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOUuhpKKSTjw.woff2) format('woff2'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhv.woff) format('woff');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}</style>
<style>
    .org-logo {
        
        background-image: url('https://www.udemy.com/staticx/udemy/images/v6/logo-coral.svg');
        
    }

    @media (min-resolution: 2dppx),
    (min-resolution: 192dpi),
    (-webkit-min-device-pixel-ratio: 2) {
        @-ms-viewport { width:device-width; zoom:1.0; }
        .org-logo {
            /*retina display*/
            
            background-image: url('https://www.udemy.com/staticx/udemy/images/v6/logo-coral.svg');
            
        }
    }
</style>
<link type="text/css" href="<?php echo base_url();?>course_uploads/85/hb.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>course_uploads/85/course-landing-components-app.css">
<style type="text/css" id="qual_style-ph_"></style>
<style type="text/css" id="qual_style-phv"></style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>course_uploads/85/course-preview-app.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>course_uploads/85/social-auth-app.css">

   
   
   

<div class="main-content-wrapper">

<div class="main-content">
<div class="clp-component-render"><div class="seo-info" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

</div></div>
<div class="clp-component-render"><div id="schema_markup" data-purpose="schema_markup">

</div></div>
<div class="clp-component-render"><div class="ud-component--clp--add-to-cart-popup" data-component-props="{&quot;experimentButtonColor&quot;:&quot;grey&quot;,&quot;is_enabled&quot;:true,&quot;buyables&quot;:[{&quot;buyableContext&quot;:{&quot;contentLocaleId&quot;:null},&quot;id&quot;:3057290,&quot;buyable_object_type&quot;:&quot;course&quot;}],&quot;addedButtonBsStyle&quot;:&quot;primary&quot;,&quot;onAddRedirectUrl&quot;:&quot;/cart/added/course/3057290/&quot;,&quot;isOnCLP&quot;:true}" data-purpose="add-to-cart-popup" ng-non-bindable=""></div></div>

<div class="full-width full-width--streamer streamer--fixed">
<div class="streamer__inner">
<div class="container">
<div class="col-md-7 left-col">
<div class="clp-component-render"><div class="clp-lead clp-lead--fixed" data-purpose="fixed-lead">
<div class="clp-lead__title clp-lead__title--fixed">
Microsoft Excel for Beginners &amp; First-time Learners
</div>

</div></div>
</div>
</div>
</div>
</div>
<div class="full-width full-width--streamer streamer--complete" data-content-group="Landing Page" data-course-id="3057290">
<div class="container">
<div class="row">
</div>
<div class="row">
<div class="col-md-7 left-col">
<div class="clp-lead">
<div class="clp-component-render"><div class="clp-component-render"><h1 class="clp-lead__title " data-purpose="lead-title">
<?php echo $course['course_name'];?>
</h1>
<div class="clp-lead__headline" data-purpose="lead-headline">
<?php echo $course['course_desc'];?>
</div></div>
<div class="clp-lead__element-row">
<div class="clp-lead__element-item">
<div class="clp-component-render"><span class="badge badge-accented green" data-purpose="badge-new-course">
New
</span></div>
</div>

</div>
<div class="clp-lead__element-row">

<div class="clp-lead__element-item">
<div class="clp-component-render"><div class="last-update-date" data-purpose="last-update-date">
<span>
Last updated <?php echo $course['date_created']; ?>
</span>
</div></div>
</div>
	<div class="clp-lead__element-item" data-purpose="lead-course-locale">
		<div class="clp-lead__language">
			<div class="clp-lead__locale">
				<span><i class="udi udi-comment"></i></span>English
			</div>

		</div>
	</div>
</div>
<div class="clp-lead__element-row">
<div class="clp-lead__element-item">
</div>
</div></div>
</div>
</div>
<div class="col-md-4 right-col js-right-col">
<div class="js-right-col__content right-col__content">
<div class="right-col__module">
<div class="clp-component-render"><div class="ud-component--clp--introduction-asset introduction-asset" data-purpose="introduction-asset" ng-non-bindable=""><div class="styles--introduction-asset--Q9xDo" data-purpose="introduction-asset"><div class="styles--introduction-asset__gradient--1dsCM"></div><a role="button" tabindex="0" class="styles--introduction-asset__link--3801E"><div class="play-button-trigger styles--introduction-asset__placeholder--3aYtt"><div class="play-button styles--play-button--akRnc"></div><span class="styles--introduction_asset__text--3e9Ce">Preview this course</span></div></a><img src="Microsoft%20Excel%20for%20Beginners%20&amp;%20First-time%20Learners%20Udemy_files/3057290_6754_2.jpg" srcset="https://img-a.udemycdn.com/course/240x135/3057290_6754_2.jpg 1x, https://img-a.udemycdn.com/course/480x270/3057290_6754_2.jpg 2x" class="styles--introduction-asset__img--9iitL" alt="" width="240" height="135"></div></div></div>
<div class="clp-component-render"><div class="right-col__inner">
	<div class="clp-component-render">
		<div class="buy-box">
			<div class="buy-box__element">
			</div>

		<div class="clp-lead__element-item">
			<div class="clp-component-render">
				
			</div>
		</div>

			<form method="post" action="<?php echo base_url();?>course/enroll_now">
				<input type="hidden" name="course_id" value="<?php echo $course_id; ?>" >
				<input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
				<div class="buy-box__element buy-box__element--row">
					<div class="clp-component-render">
						<div class="ud-component--clp--buy-button">
							<div>
								<a href="<?php  echo $files_contents[0]['is_view'] == 0 ?   base_url().'course/enroll_now/'. $category_id .'/'.$course_id : base_url().'course/view_courses/'. $category_id .'/'.$course_id ?>" class="course-cta btn btn-lg btn-primary btn-block"><?php echo $files_contents[0]['is_view'] == 0 ? 'Enroll now' : 'Proceed now' ?></a>
							</div>
						</div>
					</div>
				</div>
			</form>
			
		</div>
	</div>
<div class="clp-component-render"><div class="buy-box__element buy-box__element--money-back">
<span class="money-back">
Its a <?php echo $files_contents[0]['is_global']==1? 'Global ':'Restricted '; ?> course
</span>
</div></div>
<div class="incentives">
<div class="clp-component-render"><div>
<span id="incentives" class="in-page-offset-anchor"></span>
<div class="incentives__header">
This course includes
</div>
</div>
	<ul class="incentives__list">
		<li class="incentives__item">
			<i class="fa fa-check"></i>
			<span class="incentives__text">
				1 article
			</span>
		</li>
		<li class="incentives__item">
			<i class="fa fa-check"></i>
			<span class="incentives__text">
				1 resource
			</span>
		</li>
		<li class="incentives__item">
			<i class="fa fa-check"></i>
			<span class="incentives__text" data-purpose="incentive-lifetime-access">
			Assesment
			</span>
		</li>
	</ul>

</div>
	<div class="clp-component-render">
		<ul class="incentives__list">
			<li class="incentives__item">
			<i class="fa fa-check"></i>
				<span class="incentives__text" data-purpose="incentive-certificate">
					Certificate of Completion
				</span>
			</li>
		</ul>
	</div>
</div>


</div>
</div>
</div>

<div class="referral-terms">
<div class="clp-component-render"><div class="ud-component--clp--referral-terms" data-component-props="{}" ng-non-bindable=""></div></div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="container container--component-margin">
	<div class="row row--component-margin">
		<div class="col-md-7 left-col">
			<div class="clp-component-render"><span id="objective" class="in-page-offset-anchor"></span>
				<div class="what-you-get">
					<div class="js-simple-collapse js-simple-collapse--what-you-get" data-purpose="course-objectives" data-more="See more" style="max-height: none;">
						<div class="js-simple-collapse-inner">
							<div class="what-you-get__content">
								<div class="what-you-get__title ">
								What you'll learn
								</div>
							<ul class="what-you-get__items ">
								<li class="what-you-get__item">
									<span class="fa fa-book what-you-get__icon"></span>
									<span class="what-you-get__text"><?php echo $course['course_name']; ?></span>
								</li>
							</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row row--component-margin">
		<div class="col-md-7 left-col">
		
		</div>
	</div>
	<div class="row row--component-margin">
		<div class="col-md-7 left-col">
			<div class="clp-component-render">
				<div class="requirements" data-purpose="course-requirements">
					<div class="requirements__title">
						Requirements
					</div>
					<div class="requirements__content">
						<div class="requirements__title">
							<?php echo $course['requirement'];?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row row--component-margin">
		<div class="col-xs-8 left-col" data-purpose="curriculum-practice-test">
		
		</div>
	</div>
	<div class="row row--component-margin">
		<div class="col-md-7 left-col">
			<div class="clp-component-render">
				<div class="description js-user-tracker-click" data-purpose="course-description" data-user-tracker-schema="action-logs" data-user-tracker-object-id="3057290" data-user-tracker-action="full-description-read" data-user-tracker-target-selector-class="js-simple-collapse-more-btn">
					<div data-more="+ See more" class="js-simple-collapse js-simple-collapse--description" data-purpose="collapse-description-btn" style="max-height: none;">
						<div class="js-simple-collapse-inner" data-purpose="collapse-description-text">
							<div class="description__title">
								Description
							</div>
							<div class="">
								<p><em><?php echo $course['course_desc'];?></em></p>
								<p><br></p>
								<p><br></p>
								<p><strong>Prerequisites:</strong></p>
								<p><?php echo $course['course_desc'];?></p>
								<p><br></p>
								<p><strong>Who should take this course:</strong></p>
								<p><?php echo $course['whoshould'];?></p>
								<div class="audience" data-purpose="course-audience">
									<div class="audience__title">
										Who this course is for:
									</div>
									<div class="audience__list">
										<?php echo $course['whosfor']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
</div>
</div>
