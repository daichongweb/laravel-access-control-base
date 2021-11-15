<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\WechatAccessTokensModel;
use App\Models\WechatMembers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 微信授权服务
 */
class WechatAuthService
{
    private $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';

    private $userInfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN';

    private $refreshToken = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=%s&grant_type=refresh_token&refresh_token=%s';

    /**
     * 获取微信用户access_token
     * @throws ApiException
     */
    public function getAccessToken($enterprise, $code)
    {
        $curl = new CurlService();
        $curl->setMethod('get');
        $curl->setUrl(sprintf($this->tokenUrl, $enterprise->app_id, $enterprise->app_secret, $code));
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }

    /**
     * 刷新用户access-token
     * @param $enterprise
     * @param $refreshToken
     * @return false|mixed|string|null
     * @throws ApiException
     */
    public function refreshToken($enterprise, $refreshToken)
    {
        $curl = new CurlService();
        $curl->setMethod('get');
        $curl->setUrl(sprintf($this->refreshToken, $enterprise->app_id, $refreshToken));
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }

    /**
     * 获取用户详细信息
     * @param $accessToken
     * @param $openId
     * @return false|mixed|string|null
     * @throws ApiException
     */
    public function getUserInfo($accessToken, $openId)
    {
        $curl = new CurlService();
        $curl->setMethod('get');
        $curl->setUrl(sprintf($this->userInfoUrl, $accessToken, $openId));
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }

    /**
     * 存储token信息
     * @param $enterpriseId
     * @param $tokenData
     * @return Builder|Model
     */
    public function insertToken($enterpriseId, $tokenData)
    {
        $tokenData['enterprise_id'] = $enterpriseId;
        $tokenData['unionid'] = $tokenData['unionid'] ?? '';
        $tokenData['expires_in'] = time() + (int)$tokenData['expires_in'];
        return WechatAccessTokensModel::query()->updateOrCreate([
            'enterprise_id' => $enterpriseId,
            'openid' => $tokenData['openid'],
        ], $tokenData);
    }

    /**
     * 存储微信用户信息
     * @param $enterpriseId
     * @param $userData
     * @return Builder|Model
     */
    public function insertUser($enterpriseId, $userData)
    {
        $userData['enterprise_id'] = $enterpriseId;
        $userData['unionid'] = $userData['unionid'] ?? '';
        return WechatMembers::query()->updateOrCreate([
            'enterprise_id' => $enterpriseId,
            'openid' => $userData['openid']
        ], $userData);
    }
}
