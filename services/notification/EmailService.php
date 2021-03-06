<?php
namespace wocenter\services\notification;

use wocenter\core\Service;
use Yii;

/**
 * 邮件服务类
 */
class EmailService extends Service
{

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return 'email';
    }

    /**
     * 发送邮件
     *
     * @param string $template 模板文件
     * @param array $params 模板变量
     *  - title
     *  - content
     * @param string $to 接收邮箱
     * @param string $subject 邮箱主题
     * @param string $from 邮箱发送者
     *
     * @return boolean
     */
    public function send($template, $params, $to, $subject = '', $from = 'system')
    {
        return Yii::$app->getMailer()->compose($template, $params)
            ->setFrom(Yii::$app->params[$from . 'Email'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }

}
