<?php
namespace wocenter\services\passport\events;

use wocenter\Wc;
use wocenter\libs\Utils;
use wocenter\models\UserProfile;
use Yii;
use yii\db\Expression;
use yii\web\UserEvent;

/**
 * 更新用户登录记录以及积分和日志操作
 *
 * @auth E-Kevin <e-kevin@qq.com>
 */
class updateLoginLog
{

    /**
     * 更新用户登录记录
     *
     * @param UserEvent $event
     */
    public function run(UserEvent $event)
    {
        // 记录日志操作
        Wc::$service->getLog()->create('login', UserProfile::tableName(), $event->identity->id, $event->identity->id);

        // 更新登陆次数
        Yii::$app->getDb()->createCommand()->update(UserProfile::tableName(), [
            'last_login_ip' => Utils::getClientIp(),
            'last_login_time' => time(),
            'last_location' => Utils::getIpLocation(),
            'login_count' => new Expression('login_count + 1'),
        ], ['uid' => $event->identity->id])->execute();
    }

}
