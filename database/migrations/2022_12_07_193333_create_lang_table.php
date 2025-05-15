<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200)->nullable()->unique();
            $table->string('code2', 10)->nullable();
            $table->string('code3', 10)->nullable();
            $table->integer('status')->nullable();
            $table->string('corehtml', 10)->nullable();
            $table->integer('right_direction')->nullable();
            $table->biginteger('ordercriteria')->nullable();
            
            $table->engine = 'MyISAM';

            $table->index(['name']);
            $table->index(['code2']);
            $table->index(['code3']);
            $table->index(['status']);
            $table->index(['ordercriteria']);
        });

        
        $preparedData = $this->getPreparedData();

        DB::table('lang')->insert($preparedData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lang');
    }

    protected function getPreparedData()
    {
        $rez = array();
        foreach ($this->data as $v)
        {
            $t = array();

            $t['name'] = $v[0];
            $t['code2'] = $v[1];
            $t['code3'] = $v[2];
            $t['status'] = $v[3];
            $t['corehtml'] = $v[4];
            $t['right_direction'] = $v[5];
            $t['ordercriteria'] = $v[6];
            
            $rez[] = $t;
        }
        return $rez;
    }

    protected $data = array(
        array('Abkhazian', 'ab', 'abk', 2, '', 11, 100)
        , array('Afar', 'aa', 'aar', 2, '', 11, 100)
        , array('Afrikaans', 'af', 'afr', 2, '', 11, 100)
        , array('Albanian', 'sq', 'sqi', 2, '', 11, 100)
        , array('Amharic', 'am', 'amh', 2, '', 11, 100)
        , array('Arabic', 'ar', 'ara', 2, '', 11, 100)
        , array('Aragonese', 'an', 'arg', 2, '', 11, 100)
        , array('Armenian', 'hy', 'hye', 2, '', 11, 100)
        , array('Assamese', 'as', 'asm', 2, '', 11, 100)
        , array('Avaric', 'av', 'ava', 2, '', 11, 100)
        , array('Avestan', 'ae', 'ave', 2, '', 11, 100)
        , array('Aymara', 'ay', 'aym', 2, '', 11, 100)
        , array('Azerbaijani', 'az', 'aze', 2, '', 11, 100)
        , array('Bambara', 'bm', 'bam', 2, '', 11, 100)
        , array('Bashkir', 'ba', 'bak', 2, '', 11, 100)
        , array('Basque', 'eu', 'eus', 2, '', 11, 100)
        , array('Belarusian', 'be', 'bel', 2, '', 11, 100)
        , array('Bengali', 'bn', 'ben', 2, '', 11, 100)
        , array('Bosnian', 'bs', 'bos', 2, '', 11, 100)
        , array('Breton', 'br', 'bre', 2, '', 11, 100)
        , array('Bulgarian', 'bg', 'bul', 2, '', 11, 100)
        , array('Burmese', 'my', 'mya', 2, '', 11, 100)
        , array('Catalan, Valencian', 'ca', 'cat', 2, '', 11, 100)
        , array('Chamorro', 'ch', 'cha', 2, '', 11, 100)
        , array('Chechen', 'ce', 'che', 2, '', 11, 100)
        , array('Chichewa, Chewa, Nyanja', 'ny', 'nya', 2, '', 11, 100)
        , array('Chinese', 'zh', 'zho', 2, '', 11, 100)
        , array('ChurchВ Slavonic, Old Slavonic, OldВ ChurchВ Slavonic', 'cu', 'chu', 2, '', 11, 100)
        , array('Chuvash', 'cv', 'chv', 2, '', 11, 100)
        , array('Cornish', 'kw', 'cor', 2, '', 11, 100)
        , array('Corsican', 'co', 'cos', 2, '', 11, 100)
        , array('Cree', 'cr', 'cre', 2, '', 11, 100)
        , array('Croatian', 'hr', 'hrv', 2, '', 11, 100)
        , array('Czech', 'cs', 'ces', 2, '', 11, 100)
        , array('Danish', 'da', 'dan', 2, '', 11, 100)
        , array('Divehi, Dhivehi, Maldivian', 'dv', 'div', 2, '', 11, 100)
        , array('Dutch, Flemish', 'nl', 'nld', 2, '', 11, 100)
        , array('Dzongkha', 'dz', 'dzo', 2, '', 11, 100)
        , array('English', 'en', 'eng', 1, 'en-EN', 11, 20)
        , array('Esperanto', 'eo', 'epo', 2, '', 11, 100)
        , array('Estonian', 'et', 'est', 2, '', 11, 100)
        , array('Ewe', 'ee', 'ewe', 2, '', 11, 100)
        , array('Faroese', 'fo', 'fao', 2, '', 11, 100)
        , array('Fijian', 'fj', 'fij', 2, '', 11, 100)
        , array('Finnish', 'fi', 'fin', 2, '', 11, 100)
        , array('French', 'fr', 'fra', 2, '', 11, 100)
        , array('Western Frisian', 'fy', 'fry', 2, '', 11, 100)
        , array('Fulah', 'ff', 'ful', 2, '', 11, 100)
        , array('Gaelic, Scottish Gaelic', 'gd', 'gla', 2, '', 11, 100)
        , array('Galician', 'gl', 'glg', 2, '', 11, 100)
        , array('Ganda', 'lg', 'lug', 2, '', 11, 100)
        , array('Georgian', 'ka', 'kat', 2, '', 11, 100)
        , array('German', 'de', 'deu', 2, '', 11, 100)
        , array('Greek, Modern (1453вЂ“)', 'el', 'ell', 2, '', 11, 100)
        , array('Kalaallisut, Greenlandic', 'kl', 'kal', 2, '', 11, 100)
        , array('Guarani', 'gn', 'grn', 2, '', 11, 100)
        , array('Gujarati', 'gu', 'guj', 2, '', 11, 100)
        , array('Haitian, Haitian Creole', 'ht', 'hat', 2, '', 11, 100)
        , array('Hausa', 'ha', 'hau', 2, '', 11, 100)
        , array('Hebrew', 'he', 'heb', 2, '', 11, 100)
        , array('Herero', 'hz', 'her', 2, '', 11, 100)
        , array('Hindi', 'hi', 'hin', 2, '', 11, 100)
        , array('Hiri Motu', 'ho', 'hmo', 2, '', 11, 100)
        , array('Hungarian', 'hu', 'hun', 2, '', 11, 100)
        , array('Icelandic', 'is', 'isl', 2, '', 11, 100)
        , array('Ido', 'io', 'ido', 2, '', 11, 100)
        , array('Igbo', 'ig', 'ibo', 2, '', 11, 100)
        , array('Indonesian', 'id', 'ind', 2, '', 11, 100)
        , array('Interlingua (International Auxiliary Language Association)', 'ia', 'ina', 2, '', 11, 100)
        , array('Interlingue, Occidental', 'ie', 'ile', 2, '', 11, 100)
        , array('Inuktitut', 'iu', 'iku', 2, '', 11, 100)
        , array('Inupiaq', 'ik', 'ipk', 2, '', 11, 100)
        , array('Irish', 'ga', 'gle', 2, '', 11, 100)
        , array('Italian', 'it', 'ita', 2, '', 11, 100)
        , array('Japanese', 'ja', 'jpn', 2, '', 11, 100)
        , array('Javanese', 'jv', 'jav', 2, '', 11, 100)
        , array('Kannada', 'kn', 'kan', 2, '', 11, 100)
        , array('Kanuri', 'kr', 'kau', 2, '', 11, 100)
        , array('Kashmiri', 'ks', 'kas', 2, '', 11, 100)
        , array('Kazakh', 'kk', 'kaz', 2, '', 11, 100)
        , array('Central Khmer', 'km', 'khm', 2, '', 11, 100)
        , array('Kikuyu, Gikuyu', 'ki', 'kik', 2, '', 11, 100)
        , array('Kinyarwanda', 'rw', 'kin', 2, '', 11, 100)
        , array('Kirghiz, Kyrgyz', 'ky', 'kir', 2, '', 11, 100)
        , array('Komi', 'kv', 'kom', 2, '', 11, 100)
        , array('Kongo', 'kg', 'kon', 2, '', 11, 100)
        , array('Korean', 'ko', 'kor', 2, '', 11, 100)
        , array('Kuanyama, Kwanyama', 'kj', 'kua', 2, '', 11, 100)
        , array('Kurdish', 'ku', 'kur', 2, '', 11, 100)
        , array('Lao', 'lo', 'lao', 2, '', 11, 100)
        , array('Latin', 'la', 'lat', 2, '', 11, 100)
        , array('Latvian', 'lv', 'lav', 2, '', 11, 100)
        , array('Limburgan, Limburger, Limburgish', 'li', 'lim', 2, '', 11, 100)
        , array('Lingala', 'ln', 'lin', 2, '', 11, 100)
        , array('Lithuanian', 'lt', 'lit', 2, '', 11, 100)
        , array('Luba-Katanga', 'lu', 'lub', 2, '', 11, 100)
        , array('Luxembourgish, Letzeburgesch', 'lb', 'ltz', 2, '', 11, 100)
        , array('Macedonian', 'mk', 'mkd', 2, '', 11, 100)
        , array('Malagasy', 'mg', 'mlg', 2, '', 11, 100)
        , array('Malay', 'ms', 'msa', 2, '', 11, 100)
        , array('Malayalam', 'ml', 'mal', 2, '', 11, 100)
        , array('Maltese', 'mt', 'mlt', 2, '', 11, 100)
        , array('Manx', 'gv', 'glv', 2, '', 11, 100)
        , array('Maori', 'mi', 'mri', 2, '', 11, 100)
        , array('Marathi', 'mr', 'mar', 2, '', 11, 100)
        , array('Marshallese', 'mh', 'mah', 2, '', 11, 100)
        , array('Mongolian', 'mn', 'mon', 2, '', 11, 100)
        , array('Nauru', 'na', 'nau', 2, '', 11, 100)
        , array('Navajo, Navaho', 'nv', 'nav', 2, '', 11, 100)
        , array('North Ndebele', 'nd', 'nde', 2, '', 11, 100)
        , array('South Ndebele', 'nr', 'nbl', 2, '', 11, 100)
        , array('Ndonga', 'ng', 'ndo', 2, '', 11, 100)
        , array('Nepali', 'ne', 'nep', 2, '', 11, 100)
        , array('Norwegian', 'no', 'nor', 2, '', 11, 100)
        , array('Norwegian BokmГҐl', 'nb', 'nob', 2, '', 11, 100)
        , array('Norwegian Nynorsk', 'nn', 'nno', 2, '', 11, 100)
        , array('Sichuan Yi, Nuosu', 'ii', 'iii', 2, '', 11, 100)
        , array('Occitan', 'oc', 'oci', 2, '', 11, 100)
        , array('Ojibwa', 'oj', 'oji', 2, '', 11, 100)
        , array('Oriya', 'or', 'ori', 2, '', 11, 100)
        , array('Oromo', 'om', 'orm', 2, '', 11, 100)
        , array('Ossetian, Ossetic', 'os', 'oss', 2, '', 11, 100)
        , array('Pali', 'pi', 'pli', 2, '', 11, 100)
        , array('Pashto, Pushto', 'ps', 'pus', 2, '', 11, 100)
        , array('Persian', 'fa', 'fas', 2, '', 11, 100)
        , array('Polish', 'pl', 'pol', 2, '', 11, 100)
        , array('Portuguese', 'pt', 'por', 2, '', 11, 100)
        , array('Punjabi, Panjabi', 'pa', 'pan', 2, '', 11, 100)
        , array('Quechua', 'qu', 'que', 2, '', 11, 100)
        , array('Romanian, Moldavian, Moldovan', 'ro', 'ron', 1, 'ro-RO', 11, 10)
        , array('Romansh', 'rm', 'roh', 2, '', 11, 100)
        , array('Rundi', 'rn', 'run', 2, '', 11, 100)
        , array('Russian', 'ru', 'rus', 1, 'ru-RU', 11, 30)
        , array('Northern Sami', 'se', 'sme', 2, '', 11, 100)
        , array('Samoan', 'sm', 'smo', 2, '', 11, 100)
        , array('Sango', 'sg', 'sag', 2, '', 11, 100)
        , array('Sanskrit', 'sa', 'san', 2, '', 11, 100)
        , array('Sardinian', 'sc', 'srd', 2, '', 11, 100)
        , array('Serbian', 'sr', 'srp', 2, '', 11, 100)
        , array('Shona', 'sn', 'sna', 2, '', 11, 100)
        , array('Sindhi', 'sd', 'snd', 2, '', 11, 100)
        , array('Sinhala, Sinhalese', 'si', 'sin', 2, '', 11, 100)
        , array('Slovak', 'sk', 'slk', 2, '', 11, 100)
        , array('Slovenian', 'sl', 'slv', 2, '', 11, 100)
        , array('Somali', 'so', 'som', 2, '', 11, 100)
        , array('Southern Sotho', 'st', 'sot', 2, '', 11, 100)
        , array('Spanish, Castilian', 'es', 'spa', 2, '', 11, 100)
        , array('Sundanese', 'su', 'sun', 2, '', 11, 100)
        , array('Swahili', 'sw', 'swa', 2, '', 11, 100)
        , array('Swati', 'ss', 'ssw', 2, '', 11, 100)
        , array('Swedish', 'sv', 'swe', 2, '', 11, 100)
        , array('Tagalog', 'tl', 'tgl', 2, '', 11, 100)
        , array('Tahitian', 'ty', 'tah', 2, '', 11, 100)
        , array('Tajik', 'tg', 'tgk', 2, '', 11, 100)
        , array('Tamil', 'ta', 'tam', 2, '', 11, 100)
        , array('Tatar', 'tt', 'tat', 2, '', 11, 100)
        , array('Telugu', 'te', 'tel', 2, '', 11, 100)
        , array('Thai', 'th', 'tha', 2, '', 11, 100)
        , array('Tibetan', 'bo', 'bod', 2, '', 11, 100)
        , array('Tigrinya', 'ti', 'tir', 2, '', 11, 100)
        , array('Tonga (Tonga Islands)', 'to', 'ton', 2, '', 11, 100)
        , array('Tsonga', 'ts', 'tso', 2, '', 11, 100)
        , array('Tswana', 'tn', 'tsn', 2, '', 11, 100)
        , array('Turkish', 'tr', 'tur', 2, '', 11, 100)
        , array('Turkmen', 'tk', 'tuk', 2, '', 11, 100)
        , array('Twi', 'tw', 'twi', 2, '', 11, 100)
        , array('Uighur, Uyghur', 'ug', 'uig', 2, '', 11, 100)
        , array('Ukrainian', 'uk', 'ukr', 2, '', 11, 100)
        , array('Urdu', 'ur', 'urd', 2, '', 11, 100)
        , array('Uzbek', 'uz', 'uzb', 2, '', 11, 100)
        , array('Venda', 've', 'ven', 2, '', 11, 100)
        , array('Vietnamese', 'vi', 'vie', 2, '', 11, 100)
        , array('VolapГјk', 'vo', 'vol', 2, '', 11, 100)
        , array('Walloon', 'wa', 'wln', 2, '', 11, 100)
        , array('Welsh', 'cy', 'cym', 2, '', 11, 100)
        , array('Wolof', 'wo', 'wol', 2, '', 11, 100)
        , array('Xhosa', 'xh', 'xho', 2, '', 11, 100)
        , array('Yiddish', 'yi', 'yid', 2, '', 11, 100)
        , array('Yoruba', 'yo', 'yor', 2, '', 11, 100)
        , array('Zhuang, Chuang', 'za', 'zha', 2, '', 11, 100)
        , array('Zulu', 'zu', 'zul', 2, '', 11, 100)
        , array('namnem', '34324', 'cvbcvb', 2, '', 11, 100)
    );
};
