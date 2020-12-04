## Simple cookie

Sets up a simple cookie tool...

There are a couple of files you need to copy if you aren't using this with
wordpress:

 * cookie.js
 * cookie.css

These define the look and feel and the form - it is all generated in js so no
need to have any mark up in the page...
## Configuration via header

    <meta name="simplecookie_ga_code" content="{ GA CODE }" />
    <meta name="simplecookie_policy"  content="{ URL for policy }" />
    <meta name="simplecookie_types"   content="{ [efmt][13] }+',esc_html( get_option( 'simplecookie_types' ) ),'" />',"\n";

The types are:

  * e1 - Own essential
  * e3 - 3rd party functional
  * f1 - Own functional
  * f3 - 3rd party functional
  * t1 - Own tracking
  * t3 - 3rd party tracking
  * m1 - Own marketing
  * m3 - 3rd party marketing
  
## OR Configuration via javascript

Comment out the line:

    CookiePolicy.init().parse_meta().footer().tracking();

and replace with something like:

    CookiePolicy.set_policy_url( '/test' )   // Set privacy policy URL
      .set_ga_code(    'UA-TEST' ) // Set Google analytics code
      .set_types(      'e1', 'f1', 'f3','t3' ) // Enable types f3 and t3
      .clear_types(    't1' )      // Disable t1
      .add_type(       'o1',       // Add own type... cookie variable, "title" description, "required" true/false, "initial value" true/false
        'Other', 'Not required enhancement cookies', false, false );
      .footer()                    // Display footer (must be called)
      .tracking();                 // Block cookies in tracking if required (called if tracking)


### Support or Contact

Please contact js5@sanger.ac.uk for help.
