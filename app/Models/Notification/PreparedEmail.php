<?php

namespace App\Models\Notification;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Attachment;



class PreparedEmail extends Mailable
{
    use Queueable, SerializesModels;

    const SPKEY_TOEMAIL = '_toemail';
    const SPKEY_TONAME = 'toname';

    const SPKEY_FROMEMAIL = 'fromemail';
    const SPKEY_FROMNAME = 'fromname';

    const SPKEY_CC = 'cc';
    const SPKEY_BCC = 'bcc';

    const SPKEY_SUBJECT = 'subject';
    const SPKEY_CONCATSUBJECT = 'csubject';

    const SPKEY_REPLAYTO = 'replyto';


    public $_toemail;
    public $_toname;

    public $_fromemail;
    public $_fromname;

    public $_replyto;

    public $_cc;
    public $_bcc;

    public $_subject;
    public $_attachments;

    public $_message;
    public $_messageBody;



    public function __construct()
    {
    }
    
    public function _send()
    {
        $t = $this->build();
        return Mail::to($this->_toemail)->send($this);
    }

    public function _delete($obj){
        return $this->delete($obj);
    }

    public function build()
    {
        $params = [];
        $params['message'] = $this->_message;
        
        if ($this->_toemail) $this->to($this->_toemail);
        // if ($this->_fromemail) $this->from($this->_fromemail);
        if ($this->_subject) $this->subject($this->_subject);
        if ($this->_replyto) $this->replyTo($this->_replyto);
        if ($this->_cc)
            $this->cc($this->_cc);
        else
            $this->cc([]);

        if ($this->_bcc) 
            $this->bcc($this->_bcc);
        else
            $this->bcc([]);

        return $this->markdown('BaseSite.Emails.email', $params);
    }


    // -----
    public function setGeneralData($objTemplate, $attributes, $fromEmail)
    {
        $this->setCC($objTemplate, $attributes);
        $this->setBCC($objTemplate, $attributes);
        $this->setToEmail($objTemplate, $attributes);
        $this->setToname($objTemplate, $attributes);
        // $this->setFromEmail($attributes, $fromEmail);
        $this->setFromname($objTemplate, $attributes);
        $this->setSubject($objTemplate, $attributes);
        $this->setReplyTo($objTemplate, $attributes);
        $this->setMessage($objTemplate, $attributes);
        $this->setAttachements($objTemplate);
    }

    private function getAttribute($attributes, $key)
    {
        foreach ($attributes as $v) {
            if ($v->key == $key) {
                return $v->value;
            }
        }
        return '';
    }

    private function getSpecialAttribute($objTemplate, $attributes, $param, $key)
    {
        $rez = [];

        $t = $this->getAttribute($attributes, $key);

        if ($t)
        {
            $rez[] = $t;
        } elseif ($objTemplate->$param) {
            $rez[] = $objTemplate->$param;
        } 

        $rez = array_filter($rez);
        if (!count($rez))
            return [];
        
        return $rez;
    }

    private function setCC($objTemplate, $attributes)
    {
        $this->_cc = $this->getSpecialAttribute($objTemplate, $attributes, 'cc', self::SPKEY_CC);
    }

    private function setBCC($objTemplate, $attributes)
    {
        $this->_bcc = $this->getSpecialAttribute($objTemplate, $attributes, 'bcc', self::SPKEY_BCC);
    }


    private function setToEmail($objTemplate, $attributes)
    {
        $this->_toemail = $this->getSpecialAttribute($objTemplate, $attributes, '_toemail', self::SPKEY_TOEMAIL);
    }

    private function setToname($objTemplate, $attributes)
    {
        $this->_toname = $this->getSpecialAttribute($objTemplate, $attributes, '_toname', self::SPKEY_TONAME);
    }

    private function setFromEmail($attributes,$fromEmail)
    {
        $this->_fromemail = $this->getSpecialAttribute($fromEmail, $attributes, 'email', self::SPKEY_FROMEMAIL);
    }

    private function setFromname($objTemplate, $attributes)
    {
        $this->_fromname = $this->getSpecialAttribute($objTemplate, $attributes, '_fromname', self::SPKEY_FROMNAME);
    }

    private function setSubject($objTemplate, $attributes)
    {
        $ts = $this->getAttribute($attributes, self::SPKEY_SUBJECT);
        
        if ($ts) {
            $this->_subject = $ts;
            return;
        }

        $ts = $this->getAttribute($attributes, self::SPKEY_CONCATSUBJECT);
        $this->_subject = trim($objTemplate->_subject . ' ' . $ts);
    }

    private function setReplyTo($objTemplate, $attributes)
    {
        $this->_replyto = $this->getSpecialAttribute($objTemplate, $attributes, 'replyto', self::SPKEY_REPLAYTO);
    }

    private function setMessage($objTemplate, $attributes)
    {
        $message = $objTemplate->_message;
        $params = EmailTemplate::getParamsFromIdentifier($objTemplate->identifier);

        foreach ($params as $k => $v) {
            $t = $this->getAttribute($attributes, $k);
            $message = str_replace($k, $t, $message);
        }

        $this->_message = $message;
    }

    private function setAttachements($objTemplate)
    {
        if (
                !is_array($objTemplate->_activeAttachements)
                && !is_array($objTemplate->_activeGallery)
            ) return;

        foreach ($objTemplate->_activeAttachements as $v)
        {
            if (!$v->systemfileobj) continue;
            $tp = $v->systemfileobj->getPath();

            $ta = Attachment::fromPath($tp)->as($v->systemfileobj->name);
            $ta->attachTo($this);
        }

        foreach ($objTemplate->_activeGallery as $v)
        {
            if (!$v->systemfileobj) continue;
            $tp = $v->systemfileobj->getPath();

            $ta = Attachment::fromPath($tp)->as($v->systemfileobj->name);
            $ta->attachTo($this);
        }
    }
}