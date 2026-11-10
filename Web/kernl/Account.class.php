<?php
/* ---------------------------------------------------- */
/* 程序名称: 账户函数库
/* 程序功能: 账户加解密函数库
/* 程序开发: Source
/* 联系方式: 542112943@qq.com
/* Date: 1970-01-01 / 2019-01-01
/* ---------------------------------------------------- */
/* 使用条款:
/* 1.该软件免费使用.
/* 2.禁止任何衍生版本.
/* ---------------------------------------------------- */
/* 安全修订说明（2026）：
/*  1. 变量$key{$x}字符串偏移写法在 PHP8 已移除，统一改为数组下标
/*  2. 初始化 $char/$str，避免 PHP7 下的未定义变量告警
/*  3. 保留原有可逆加密算法以兼容历史密码数据（升级方案见审计报告）
/* ---------------------------------------------------- */

class Account
{
    // 密码加密（保持与历史数据一致的可逆算法）
    public static function PwdEnc($data, $key)
    {
        $data = (string)$data;
        $key  = md5((string)$key);
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char = '';
        $str  = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= $key[$x];
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            $str .= chr((ord($data[$i]) + ord($char[$i])) % 256);
        }
        return base64_encode($str);
    }

    // 密码解密（仅供迁移/校验使用，登录流程不再依赖）
    public static function decrypt($data, $key)
    {
        $key  = md5((string)$key);
        $x    = 0;
        $data = base64_decode((string)$data, true);
        if ($data === false) {
            return '';
        }
        $len  = strlen($data);
        $l    = strlen($key);
        $char = '';
        $str  = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            $d = ord($data[$i]);
            $c = ord($char[$i]);
            if ($d < $c) {
                $str .= chr(($d + 256) - $c);
            } else {
                $str .= chr($d - $c);
            }
        }
        return $str;
    }
}

