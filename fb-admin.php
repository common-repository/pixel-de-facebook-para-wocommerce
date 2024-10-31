<?php
if(!defined('ABSPATH')) exit;
add_action( 'admin_menu', 'pfb_woo_menu');
function pfb_woo_menu() {add_options_page('Pixel de Facebook', 'Facebook Pixel','manage_options', 'facebook-pixel', 'pfb_woo_conf');}
function pfb_woo_conf() {
?>
<style>
#wrap{margin:0; padding:0;}
#col1{width:600px;float:left;text-align:left;padding:0 0 0 10px; margin: 0 10px 0 0}
#col2{width:170px;float:left;text-align:right;padding:0 10px 0 0}
#col3{width:790px;clear:both; margin:20px 0;border-bottom:1px solid #ccc;font-size:20px;padding:0 0 10px 10px}
#guardar{width:800px;clear:both; margin:20px 0}
.instruccion{ font-style:italic; font-size:13px;color:#888; margin:12px 0 0 0}
@media screen and (max-width: 899px) {
#col1{width:500px}
#col2{width:170px}
#col3{width:690px}
#guardar{width:700px}
}
@media screen and (max-width: 767px) {
#col1{width:450px}
#col2{width:170px}
#col3{width:640px}
#guardar{width:650px}
}
@media screen and (max-width: 479px) {
#col1{width:170px}
#col2{width:150px}
#col3{width:340px}
#guardar{width:350px}
}
</style>

<div class="wrap">	
<h2>Pixel de Facebook para Woocommerce</h2>   
<form method="post" action='options.php' id="guardar">
	<?php settings_fields('pfb_woo_options'); ?>
    <?php do_settings_sections('fb_eventos'); ?>
<input class="button-primary" type="submit" name="submit" value="Guardar cambios" style="margin:20px 0 0 20px" />
</form>      
</div>
  
<?php
}

add_action('admin_init', 'pfb_woo_admin_init');

function pfb_woo_admin_init() {
	register_setting('pfb_woo_options','pfb_woo_options','pfb_woo_validate');
	add_settings_section('pfb_woo_main','', 'pfb_woo_section_text','fb_eventos');
	add_settings_field('pfb_woo_id_', '','pfb_woo_conf_id_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_inc', '','pfb_woo_conf_inc_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_ref', '','pfb_woo_conf_ref_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_mon', '','pfb_woo_conf_mon_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_tax', '','pfb_woo_conf_tax_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_vc_', '','pfb_woo_conf_vc_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_adc', '','pfb_woo_conf_adc_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_ic_', '','pfb_woo_conf_ic_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_pur', '','pfb_woo_conf_pur_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_vcs', '','pfb_woo_conf_vcs_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_vca', '','pfb_woo_conf_vca_input','fb_eventos','pfb_woo_main');
	add_settings_field('pfb_woo_vct', '','pfb_woo_conf_vct_input','fb_eventos','pfb_woo_main');
}

/* DOCUMENTACION */
function pfb_woo_section_text() {
	echo "<a href='https://www.labschool.es/guia-como-configurar-anuncios-dinamicos-en-facebook/' target='_blank'>Documentaci&oacute;n del plugin</a>";
}

/* ID FACEBOOK */
function pfb_woo_conf_id_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['id'];
	echo "<div id='col3'>Configuraci&oacute;n B&aacute;sica</div>";
	echo "<div id='col1'><label>Facebook Pixel ID</label>
		  <div class='instruccion'>Introduce el ID del pixel facilitado por Facebook <a href='https://www.facebook.com/ads/manager/pixel/facebook_pixel/' target='_blank'>&iquest;C&oacute;mo obtener el ID?</a></div></div>";
	echo "<div id='col2'><input id='id' name='pfb_woo_options[id]' type='text' value='$id' /></div>";
}

/* INCLUIR CODIGO SEGUIMIENTO */
function pfb_woo_conf_inc_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['include_snippet'];
	echo "<div id='col1'><label>Agregar p&iacute;xel de Facebook</label><br />
		  <div class='instruccion'>No actives esta opci&oacute;n si has agregado manualmente el c&oacute;digo del pixel en el header.php de la plantilla.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[include_snippet]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* REFERENCIA PRODUCTO */
function pfb_woo_conf_ref_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['product_ref'];
	echo "<div id='col3'>Configuraci&oacute;n Avanzada</div>";
	echo "<div id='col1'><label><strong>Identificador de producto</strong></label>
		  <div class='instruccion'>Puedes identificar la referencia del producto mediante el ID de Wordpress o el SKU que hayas definido.</div></div>";
	echo "<div id='col2'><select name='pfb_woo_options[product_ref]'>
				<option value='1' " . selected( $id , 1,false) . ">ID Producto</option>
				<option value='0' " . selected( $id , 0,false) . ">SKU</option>
		  </div>";
}

/* TIPO DE MONEDA */
function pfb_woo_conf_mon_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['currency'];
	echo "<div id='col1'><label><strong>Tipo de divisa</strong></label>
		  <div class='instruccion'>La divisa debe coincidir con la que hayas configurado en Woocommerce seg&uacute;n norma ISO 4217.</div></div>";
	echo "<div id='col2'><select name='pfb_woo_options[currency]'>
				<option value='EUR' " . selected( $id , 'EUR',false) . ">EUR - Euro</option>
				<option value='AED' " . selected( $id , 'AED',false) . ">AED - D&iacute;rham de los Emiratos &Aacute;rabes Unidos</option>
				<option value='AFN' " . selected( $id , 'AFN',false) . ">AFN - Afgani</option>
				<option value='ALL' " . selected( $id , 'ALL',false) . ">ALL - Lek</option>
				<option value='AMD' " . selected( $id , 'AMD',false) . ">AMD - Dram armenio</option>
				<option value='ANG' " . selected( $id , 'ANG',false) . ">ANG - Flor&iacute;n antillano neerland&eacute;s</option>
				<option value='AOA' " . selected( $id , 'AOA',false) . ">AOA - Kwanza</option>
				<option value='ARS' " . selected( $id , 'ARS',false) . ">ARS - Peso argentino</option>
				<option value='AUD' " . selected( $id , 'AUD',false) . ">AUD - D&oacute;lar australiano</option>
				<option value='AWG' " . selected( $id , 'AWG',false) . ">AWG - Flor&iacute;n arube&ntilde;o</option>
				<option value='AZN' " . selected( $id , 'AZN',false) . ">AZN - Manat azerbaiyano</option>
				<option value='BAM' " . selected( $id , 'BAM',false) . ">BAM - Marco convertible</option>
				<option value='BBD' " . selected( $id , 'BBD',false) . ">BBD - D&oacute;lar de Barbados</option>
				<option value='BDT' " . selected( $id , 'BDT',false) . ">BDT - Taka</option>
				<option value='BGN' " . selected( $id , 'BGN',false) . ">BGN - Lev b&uacute;lgaro</option>
				<option value='BHD' " . selected( $id , 'BHD',false) . ">BHD - Dinar barein&iacute;</option>
				<option value='BIF' " . selected( $id , 'BIF',false) . ">BIF - Franco de Burundi</option>
				<option value='BMD' " . selected( $id , 'BMD',false) . ">BMD - D&oacute;lar bermude&ntilde;o</option>
				<option value='BND' " . selected( $id , 'BND',false) . ">BND - D&oacute;lar de Brun&eacute;i</option>
				<option value='BOB' " . selected( $id , 'BOB',false) . ">BOB - Boliviano</option>
				<option value='BOV' " . selected( $id , 'BOV',false) . ">BOV - MVDOL</option>
				<option value='BRL' " . selected( $id , 'BRL',false) . ">BRL - Real brasile&ntilde;o</option>
				<option value='BSD' " . selected( $id , 'BSD',false) . ">BSD - D&oacute;lar bahame&ntilde;o</option>
				<option value='BTN' " . selected( $id , 'BTN',false) . ">BTN - Ngultrum</option>
				<option value='BWP' " . selected( $id , 'BWP',false) . ">BWP - Pula</option>
				<option value='BYN' " . selected( $id , 'BYN',false) . ">BYN - Rublo bielorruso</option>
				<option value='BZD' " . selected( $id , 'BZD',false) . ">BZD - D&oacute;lar belice&ntilde;o</option>
				<option value='CAD' " . selected( $id , 'CAD',false) . ">CAD - D&oacute;lar canadiense</option>
				<option value='CDF' " . selected( $id , 'CDF',false) . ">CDF - Franco congole&ntilde;o</option>
				<option value='CHE' " . selected( $id , 'CHE',false) . ">CHE - Euro WIR</option>
				<option value='CHF' " . selected( $id , 'CHF',false) . ">CHF - Franco suizo</option>
				<option value='CHW' " . selected( $id , 'CHW',false) . ">CHW - Franco WIR</option>
				<option value='CLF' " . selected( $id , 'CLF',false) . ">CLF - Unidad de fomento</option>
				<option value='CLP' " . selected( $id , 'CLP',false) . ">CLP - Peso chileno</option>
				<option value='CNY' " . selected( $id , 'CNY',false) . ">CNY - Yuan chino</option>
				<option value='COP' " . selected( $id , 'COP',false) . ">COP - Peso colombiano</option>
				<option value='COU' " . selected( $id , 'COU',false) . ">COU - Unidad de valor real</option>
				<option value='CRC' " . selected( $id , 'CRC',false) . ">CRC - Col&oacute;n costarricense</option>
				<option value='CUC' " . selected( $id , 'CUC',false) . ">CUC - Peso convertible</option>
				<option value='CUP' " . selected( $id , 'CUP',false) . ">CUP - Peso cubano</option>
				<option value='CVE' " . selected( $id , 'CVE',false) . ">CVE - Escudo caboverdiano</option>
				<option value='CZK' " . selected( $id , 'CZK',false) . ">CZK - Corona checa</option>
				<option value='DJF' " . selected( $id , 'DJF',false) . ">DJF - Franco yibutiano</option>
				<option value='DKK' " . selected( $id , 'DKK',false) . ">DKK - Corona danesa</option>
				<option value='DOP' " . selected( $id , 'DOP',false) . ">DOP - Peso dominicano</option>
				<option value='DZD' " . selected( $id , 'DZD',false) . ">DZD - Dinar argelino</option>
				<option value='EGP' " . selected( $id , 'EGP',false) . ">EGP - Libra egipcia</option>
				<option value='ERN' " . selected( $id , 'ERN',false) . ">ERN - Nakfa</option>
				<option value='ETB' " . selected( $id , 'ETB',false) . ">ETB - Birr et&iacute;ope</option>
				<option value='FJD' " . selected( $id , 'FJD',false) . ">FJD - D&oacute;lar fiyiano</option>
				<option value='FKP' " . selected( $id , 'FKP',false) . ">FKP - Libra malvinense</option>
				<option value='GBP' " . selected( $id , 'GBP',false) . ">GBP - Libra esterlina</option>
				<option value='GEL' " . selected( $id , 'GEL',false) . ">GEL - Lari</option>
				<option value='GHS' " . selected( $id , 'GHS',false) . ">GHS - Cedi ghan&eacute;s</option>
				<option value='GIP' " . selected( $id , 'GIP',false) . ">GIP - Libra de Gibraltar</option>
				<option value='GMD' " . selected( $id , 'GMD',false) . ">GMD - Dalasi</option>
				<option value='GNF' " . selected( $id , 'GNF',false) . ">GNF - Franco guineano</option>
				<option value='GTQ' " . selected( $id , 'GTQ',false) . ">GTQ - Quetzal</option>
				<option value='GYD' " . selected( $id , 'GYD',false) . ">GYD - D&oacute;lar guyan&eacute;s</option>
				<option value='HKD' " . selected( $id , 'HKD',false) . ">HKD - D&oacute;lar de Hong Kong</option>
				<option value='HNL' " . selected( $id , 'HNL',false) . ">HNL - Lempira</option>
				<option value='HRK' " . selected( $id , 'HRK',false) . ">HRK - Kuna</option>
				<option value='HTG' " . selected( $id , 'HTG',false) . ">HTG - Gourde</option>
				<option value='HUF' " . selected( $id , 'HUF',false) . ">HUF - Forinto</option>
				<option value='IDR' " . selected( $id , 'IDR',false) . ">IDR - Rupia indonesia</option>
				<option value='ILS' " . selected( $id , 'ILS',false) . ">ILS - Nuevo sh&eacute;quel israel&iacute;</option>
				<option value='INR' " . selected( $id , 'INR',false) . ">INR - Rupia india</option>
				<option value='IQD' " . selected( $id , 'IQD',false) . ">IQD - Dinar iraqu&iacute;</option>
				<option value='IRR' " . selected( $id , 'IRR',false) . ">IRR - Rial iran&iacute;</option>
				<option value='ISK' " . selected( $id , 'ISK',false) . ">ISK - Corona islandesa</option>
				<option value='JMD' " . selected( $id , 'JMD',false) . ">JMD - D&oacute;lar jamaiquino</option>
				<option value='JOD' " . selected( $id , 'JOD',false) . ">JOD - Dinar jordano</option>
				<option value='JPY' " . selected( $id , 'JPY',false) . ">JPY - Yen</option>
				<option value='KES' " . selected( $id , 'KES',false) . ">KES - Chel&iacute;n keniano</option>
				<option value='KGS' " . selected( $id , 'KGS',false) . ">KGS - Som</option>
				<option value='KHR' " . selected( $id , 'KHR',false) . ">KHR - Riel</option>
				<option value='KMF' " . selected( $id , 'KMF',false) . ">KMF - Franco comorense</option>
				<option value='KPW' " . selected( $id , 'KPW',false) . ">KPW - Won norcoreano</option>
				<option value='KRW' " . selected( $id , 'KRW',false) . ">KRW - Won</option>
				<option value='KWD' " . selected( $id , 'KWD',false) . ">KWD - Dinar kuwait&iacute;</option>
				<option value='KYD' " . selected( $id , 'KYD',false) . ">KYD - D&oacute;lar de las Islas Caim&aacute;n</option>
				<option value='KZT' " . selected( $id , 'KZT',false) . ">KZT - Tenge</option>
				<option value='LAK' " . selected( $id , 'LAK',false) . ">LAK - Kip</option>
				<option value='LBP' " . selected( $id , 'LBP',false) . ">LBP - Libra libanesa</option>
				<option value='LKR' " . selected( $id , 'LKR',false) . ">LKR - Rupia de Sri Lanka</option>
				<option value='LRD' " . selected( $id , 'LRD',false) . ">LRD - D&oacute;lar liberiano</option>
				<option value='LSL' " . selected( $id , 'LSL',false) . ">LSL - Loti</option>
				<option value='LYD' " . selected( $id , 'LYD',false) . ">LYD - Dinar libio</option>
				<option value='MAD' " . selected( $id , 'MAD',false) . ">MAD - D&iacute;rham marroqu&iacute;</option>
				<option value='MDL' " . selected( $id , 'MDL',false) . ">MDL - Leu moldavo</option>
				<option value='MGA' " . selected( $id , 'MGA',false) . ">MGA - Ariary malgache</option>
				<option value='MKD' " . selected( $id , 'MKD',false) . ">MKD - Denar</option>
				<option value='MMK' " . selected( $id , 'MMK',false) . ">MMK - Kyat</option>
				<option value='MNT' " . selected( $id , 'MNT',false) . ">MNT - Tugrik</option>
				<option value='MOP' " . selected( $id , 'MOP',false) . ">MOP - Pataca</option>
				<option value='MRU' " . selected( $id , 'MRU',false) . ">MRU - Uguiya</option>
				<option value='MUR' " . selected( $id , 'MUR',false) . ">MUR - Rupia de Mauricio</option>
				<option value='MVR' " . selected( $id , 'MVR',false) . ">MVR - Rufiyaa</option>
				<option value='MWK' " . selected( $id , 'MWK',false) . ">MWK - Kwacha</option>
				<option value='MXN' " . selected( $id , 'MXN',false) . ">MXN - Peso mexicano</option>
				<option value='MYR' " . selected( $id , 'MYR',false) . ">MYR - Ringgit malayo</option>
				<option value='MZN' " . selected( $id , 'MZN',false) . ">MZN - Metical mozambique&ntilde;o</option>
				<option value='NAD' " . selected( $id , 'NAD',false) . ">NAD - D&oacute;lar namibio</option>
				<option value='NGN' " . selected( $id , 'NGN',false) . ">NGN - Naira</option>
				<option value='NIO' " . selected( $id , 'NIO',false) . ">NIO - Nicaragua</option>
				<option value='NOK' " . selected( $id , 'NOK',false) . ">NOK - Corona noruega</option>
				<option value='NPR' " . selected( $id , 'NPR',false) . ">NPR - Rupia nepal&iacute;</option>
				<option value='NZD' " . selected( $id , 'NZD',false) . ">NZD - D&oacute;lar neozeland&eacute;s</option>
				<option value='OMR' " . selected( $id , 'OMR',false) . ">OMR - Rial oman&iacute;</option>
				<option value='PAB' " . selected( $id , 'PAB',false) . ">PAB - Balboa</option>
				<option value='PEN' " . selected( $id , 'PEN',false) . ">PEN - Sol</option>
				<option value='PGK' " . selected( $id , 'PGK',false) . ">PGK - Kina</option>
				<option value='PHP' " . selected( $id , 'PHP',false) . ">PHP - Peso filipino</option>
				<option value='PKR' " . selected( $id , 'PKR',false) . ">PKR - Rupia pakistan&iacute;</option>
				<option value='PLN' " . selected( $id , 'PLN',false) . ">PLN - Esloti</option>
				<option value='PYG' " . selected( $id , 'PYG',false) . ">PYG - Guaran&iacute;</option>
				<option value='QAR' " . selected( $id , 'QAR',false) . ">QAR - Riyal qatar&iacute;</option>
				<option value='RON' " . selected( $id , 'RON',false) . ">RON - Leu rumano</option>
				<option value='RSD' " . selected( $id , 'RSD',false) . ">RSD - Dinar serbio</option>
				<option value='RUB' " . selected( $id , 'RUB',false) . ">RUB - Rublo ruso</option>
				<option value='RWF' " . selected( $id , 'RWF',false) . ">RWF - Franco ruand&eacute;s</option>
				<option value='SAR' " . selected( $id , 'SAR',false) . ">SAR - Riyal saud&iacute;</option>
				<option value='SBD' " . selected( $id , 'SBD',false) . ">SBD - D&oacute;lar de las Islas Salom&oacute;n</option>
				<option value='SCR' " . selected( $id , 'SCR',false) . ">SCR - Rupia seychelense</option>
				<option value='SDG' " . selected( $id , 'SDG',false) . ">SDG - Dinar sudan&eacute;s</option>
				<option value='SEK' " . selected( $id , 'SEK',false) . ">SEK - Corona sueca</option>
				<option value='SGD' " . selected( $id , 'SGD',false) . ">SGD - D&oacute;lar de Singapur</option>
				<option value='SHP' " . selected( $id , 'SHP',false) . ">SHP - Libra de Santa Elena</option>
				<option value='SLL' " . selected( $id , 'SLL',false) . ">SLL - Leone</option>
				<option value='SOS' " . selected( $id , 'SOS',false) . ">SOS - Chel&iacute;n somal&iacute;</option>
				<option value='SRD' " . selected( $id , 'SRD',false) . ">SRD - D&oacute;lar surinam&eacute;s</option>
				<option value='SSP' " . selected( $id , 'SSP',false) . ">SSP - Libra sursudanesa</option>
				<option value='STN' " . selected( $id , 'STN',false) . ">STN - Dobra</option>
				<option value='SVC' " . selected( $id , 'SVC',false) . ">SVC - Colon Salvadore&ntilde;o</option>
				<option value='SYP' " . selected( $id , 'SYP',false) . ">SYP - Libra siria</option>
				<option value='SZL' " . selected( $id , 'SZL',false) . ">SZL - Lilangeni</option>
				<option value='THB' " . selected( $id , 'THB',false) . ">THB - Baht</option>
				<option value='TJS' " . selected( $id , 'TJS',false) . ">TJS - Somoni tayiko</option>
				<option value='TMT' " . selected( $id , 'TMT',false) . ">TMT - Manat turcomano</option>
				<option value='TND' " . selected( $id , 'TND',false) . ">TND - Dinar tunecino</option>
				<option value='TOP' " . selected( $id , 'TOP',false) . ">TOP - Pa'anga</option>
				<option value='TRY' " . selected( $id , 'TRY',false) . ">TRY - Lira turca</option>
				<option value='TTD' " . selected( $id , 'TTD',false) . ">TTD - D&oacute;lar de Trinidad y Tobago</option>
				<option value='TWD' " . selected( $id , 'TWD',false) . ">TWD - Nuevo d&oacute;lar taiwan&eacute;s</option>
				<option value='TZS' " . selected( $id , 'TZS',false) . ">TZS - Chel&iacute;n tanzano</option>
				<option value='UAH' " . selected( $id , 'UAH',false) . ">UAH - Grivna</option>
				<option value='UGX' " . selected( $id , 'UGX',false) . ">UGX - Chel&iacute;n ugand&eacute;s</option>
				<option value='USD' " . selected( $id , 'USD',false) . ">USD - D&oacute;lar estadounidense</option>
				<option value='UYI' " . selected( $id , 'UYI',false) . ">UYI - Peso en Unidades Indexadas (Uruguay)</option>
				<option value='UYU' " . selected( $id , 'UYU',false) . ">UYU - Peso uruguayo</option>
				<option value='UZS' " . selected( $id , 'UZS',false) . ">UZS - Som uzbeko</option>
				<option value='VND' " . selected( $id , 'VND',false) . ">VND - Dong vietnamita</option>
				<option value='VUV' " . selected( $id , 'VUV',false) . ">VUV - Vatu</option>
				<option value='WST' " . selected( $id , 'WST',false) . ">WST - Tala</option>
				<option value='XAF' " . selected( $id , 'XAF',false) . ">XAF - Franco CFA de &Aacute;frica Central</option>
				<option value='XCD' " . selected( $id , 'XCD',false) . ">XCD - D&oacute;lar del Caribe Oriental</option>
				<option value='XDR' " . selected( $id , 'XDR',false) . ">XDR - Derechos especiales de giro</option>
				<option value='XOF' " . selected( $id , 'XOF',false) . ">XOF - Franco CFA de &Aacute;frica Occidental</option>
				<option value='XPF' " . selected( $id , 'XPF',false) . ">XPF - Franco CFP</option>
				<option value='XSU' " . selected( $id , 'XSU',false) . ">XSU - SUCRE</option>
				<option value='XUA' " . selected( $id , 'XUA',false) . ">XUA - Unidad de cuenta BAD</option>
				<option value='YER' " . selected( $id , 'YER',false) . ">YER - Rial yemen&iacute;</option>
				<option value='ZAR' " . selected( $id , 'ZAR',false) . ">ZAR - Rand</option>
				<option value='ZMW' " . selected( $id , 'ZMW',false) . ">ZMW - Kwacha zambiano</option>
				<option value='ZWL' " . selected( $id , 'ZWL',false) . ">ZWL - D&oacute;lar zimbabuense</option>
		  </div>";
}

/* IMPUESTOS */
function pfb_woo_conf_tax_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['taxes'];
	echo "<div id='col1'><label><strong>Aplicar impuestos</strong></label>
		  <div class='instruccion'>Incluye los impuestos sobre los precios recogidos en los diferentes eventos activados.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[taxes]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}


/* EVENTO VIEWCONTENT */
function pfb_woo_conf_vc_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['view_content'];
	echo "<div id='col3'>Eventos Est&aacute;ndar</div>";
	echo "<div id='col1'><label><strong>ViewContent</strong></label>
		  <div class='instruccion'>Incluye el evento 'ViewContent' cada vez que se carga una p&aacute;gina de producto.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[view_content]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* EVENTO ADDTOCART */
function pfb_woo_conf_adc_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['add_to_cart'];
	echo "<div id='col1'><label><strong>AddToCart</strong></label>
		  <div class='instruccion'>Incluye el evento 'AddToCart' cada vez que se carga la p&aacute;gina del carrito.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[add_to_cart]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* EVENTO INITIATECHECKOUT */
function pfb_woo_conf_ic_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['initiate_checkout'];
	echo "<div id='col1'><label><strong>InitiateCheckout</strong></label>
		  <div class='instruccion'>Incluye el evento 'InitiateCheckout' cada vez que se carga la p&aacute;gina de finalizar la compra.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[initiate_checkout]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* EVENTO PURCHASE */
function pfb_woo_conf_pur_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['purchase'];
	echo "<div id='col1'><label><strong>Purchase</strong></label>
		  <div class='instruccion'>Incluye el evento 'Purchase' cada vez que se carga la p&aacute;gina de agradecimiento tras realizar una compra.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[purchase]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* EVENTO VIEWSHOP */
function pfb_woo_conf_vcs_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['view_shop'];
	echo "<div id='col3'>Eventos Personalizados</div>";
	echo "<div id='col1'><label><strong>ViewShop</strong></label>
		  <div class='instruccion'>Incluye el evento personalizado 'ViewShop' cada vez que se carga una p&aacute;gina del cat&aacute;logo de productos.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[view_shop]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* EVENTO VIEWCATEGORY */
function pfb_woo_conf_vca_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['view_category'];
	echo "<div id='col1'><label><strong>ViewCategory</strong></label>
		  <div class='instruccion'>Incluye el evento personalizado 'ViewCategory' cada vez que se carga una p&aacute;gina de categor&iacute;a de productos.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[view_category]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* EVENTO VIEWTAG */
function pfb_woo_conf_vct_input() {
	$options = get_option('pfb_woo_options');
	$id = $options['view_tag'];
	echo "<div id='col1'><label><strong>ViewTag</strong></label>
		  <div class='instruccion'>Incluye el evento personalizado 'ViewTag' cada vez que se carga una p&aacute;gina de etiqueta de productos.</div></div>";
	echo "<div id='col2'><input name='pfb_woo_options[view_tag]' type='checkbox' value='1' " . checked( $id , 1,false) . " /></div>";
}

/* GUARDAR OPCIONES */
function pfb_woo_validate($form){
	$options = get_option('pfb_woo_options');
	$updated = $options;
	$updated['id'] = $form['id'];
	$updated['include_snippet'] = $form['include_snippet'];
	$updated['product_ref'] = $form['product_ref'];
	$updated['currency'] = $form['currency'];
	$updated['taxes'] = $form['taxes'];
	$updated['view_content'] = $form['view_content'];
	$updated['view_shop'] = $form['view_shop'];
	$updated['view_category'] = $form['view_category'];
	$updated['view_tag'] = $form['view_tag'];
	$updated['add_to_cart'] = $form['add_to_cart'];
	$updated['initiate_checkout'] = $form['initiate_checkout'];
	$updated['purchase'] = $form['purchase'];
	return $updated;
}

?>
