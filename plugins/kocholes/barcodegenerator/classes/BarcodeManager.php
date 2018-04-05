<?php namespace Kocholes\BarcodeGenerator\Classes;

use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class BarcodeManager {
    
    /**
     * Types for 1D barcodes
     * 
     * @var array 
     */
    public static $TYPES_1D = [
        'C39' => 'CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9',
        'C39+' => 'CODE 39 with checksum',
        'C39E' => 'CODE 39 Extended',
        'C39E+' => 'CODE 39 Extended with checksum',
        'C93' => 'CODE 93 - USS-93',
        'S25' => '(S25) Standard 2 of 5',
        'S25+' => '(S25) Standard 2 of 5 with checksum',
        'I25' => '(I25) Interleaved 2 of 5',
        'I25+' => '(I25) Interleaved 2 of 5 with checksum',
        'C128' => 'CODE 128',
        'C128A' => 'CODE 128 A',
        'C128B' => 'CODE 128 B',
        'C128C' => 'CODE 128 C',
        'EAN2' => '(EAN 2) 2-Digits UPC-Based Extention',
        'EAN5' => '(EAN 5) 5-Digits UPC-Based Extention',
        'EAN8' => 'EAN 8',
        'EAN13' => 'EAN 13',
        'UPCA' => 'UPC-A',
        'UPCE' => 'UPC-E',
        'MSI' => 'MSI (Variation of Plessey code)',
        'MSI+' => 'MSI with checksum (modulo 11)',
        'POSTNET' => 'POSTNET',
        'PLANET' => 'PLANET',
        'RMS4CC' => '(RMS4CC) Royal Mail 4-state Customer Code - (CBC) Customer Bar Code',
        'KIX' => '(KIX) Klant index - Customer index',
        'IMB' => '(IMB) Intelligent Mail Barcode - Onecode - USPS-B-3200',
        'CODABAR' => 'CODABAR',
        'CODE11' => 'CODE 11',
        'PHARMA' => 'PHARMACODE',
        'PHARMA2T' => 'PHARMACODE TWO-TRACKS'
    ];
    
    /**
     * Types for 2D barcodes
     * 
     * @var array 
     */
    public static $TYPES_2D = [
        'QRCODE' => 'QRcode',
        'PDF417' => 'PDF417 (ISO/IEC 15438:2006)',
        'DATAMATRIX'=> 'Datamatrix (ISO/IEC 16022)'
    ];
    
    /** and those?    
    PDF417,a,e,t,s,f,o0,o1,o2,o3,o4,o5,o6 : PDF417 with parameters: a = aspect ratio (width/height); e = error correction level (0-8); t = total number of macro segments; s = macro segment index (0-99998); f = file ID; o0 = File Name (text); o1 = Segment Count (numeric); o2 = Time Stamp (numeric); o3 = Sender (text); o4 = Addressee (text); o5 = File Size (numeric); o6 = Checksum (numeric). NOTES: Parameters t, s and f are required for a Macro Control Block, all other parametrs are optional. To use a comma character ',' on text options, replace it with the character 255: "\xff".
    QRCODE,L : QRcode Low error correction
    QRCODE,M : QRcode Medium error correction
    QRCODE,Q : QRcode Better error correction
    QRCODE,H : QR-CODE Best error correction
    RAW: raw mode - comma-separad list of array rows
    RAW2: raw mode - array rows are surrounded by square parenthesis.
    TEST : Test matrix
     */
    
    public function __construct() {
    }
    
    /**
     * Return an HTML representation of barcode.
     * 
     * @param string $format Output format (HTML,SVG,PNG)
     * @param string $data data to codify
     * @param string $type type of barcode
     * @param int $w Width of a single rectangle element in pixels.
     * @param int $h Height of a single rectangle element in pixels.
     * @param string $color Foreground color for bar elements (background is transparent).
     * @return string
     */
    public function getBarcode($format, $data, $type, $w, $h, $color) {
        if(isset(self::$TYPES_1D[$type])) {
            $generator = new DNS1D();
        } 
        else if(isset(self::$TYPES_2D[$type])) {
            $generator = new DNS2D();
            if($w == 2 and $h == 30) {
                $w = 10;
                $h = 10;
            }
        }
        
        if($format == 'HTML') {
            return $generator->getBarcodeHTML($data, $type, $w, $h, $color);
        } 
        else if($format == 'SVG') {
            return $generator->getBarcodeSVG($data, $type, $w, $h, $color);
        } 
        else if($format == 'PNG') {
            return $generator->getBarcodePNG($data, $type, $w, $h, $color);
        }
    }
    
}
