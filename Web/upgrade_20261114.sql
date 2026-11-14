-- =============================================================================
--  Source 软件管家 · 数据库升级脚本
--  版本标识：2026-11-14 / 第四轮（操作日志 + 安全防御开关）
--  适用场景：把旧库升级到「后台操作日志、登录审计、CSRF/XSS/SQLi/路径穿越
--            四个可开关防御项」所需的数据库结构。
--
--  【特性】整份脚本可重复执行（幂等）：
--          · 表/列已存在 → 跳过；
--          · 防御开关已有值 → 保持原值，不覆盖你手动关闭过的项。
--
--  【执行方式】
--    A. 命令行（推荐）
--       mysql -h 192.168.2.252 -P 3306 -u root -p --default-character-set=utf8mb4 \
--             newsoftmanager < upgrade_20261114.sql
--    B. phpMyAdmin / Navicat：整段复制粘贴执行（脚本不含 DELIMITER，可直接跑）
--
--  【执行前】建议先备份：
--       mysqldump -h 192.168.2.252 -u root -p --default-character-set=utf8mb4 \
--                 newsoftmanager > backup_before_upgrade.sql
--
--  说明：本脚本只做“补结构 + 补配置默认值”，不改动任何业务数据
--        （不触碰 zd_software / zd_type / zd_content_data 等表）。
-- =============================================================================

SET NAMES utf8mb4;

-- =============================================================================
-- 1. 系统日志表：不存在则创建（全新库也能直接跑）
-- =============================================================================
CREATE TABLE IF NOT EXISTS `zd_system_log` (
  `id`     int(11)  NOT NULL AUTO_INCREMENT,
  `method` text     DEFAULT NULL,
  `ip`     text     NOT NULL,
  `data`   text     NOT NULL,
  `addr`   text     NOT NULL,
  `time`   text     NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- =============================================================================
-- 2. 系统日志表：修复 id「非自增 / 无主键」
--    这是老库最典型的坑：id 没有 AUTO_INCREMENT 也没有主键，
--    每次 INSERT 都会报 1364 Field 'id' doesn't have a default value，
--    而写入函数捕获错误后静默忽略 → 日志页永远是空的。
-- =============================================================================

-- 2.1 有表、但没有任何主键 → 一次性补「自增 + 主键」
SET @has_table := (SELECT COUNT(*) FROM information_schema.TABLES
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log');
SET @has_pk    := (SELECT COUNT(*) FROM information_schema.STATISTICS
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log'
                     AND INDEX_NAME = 'PRIMARY');
SET @id_extra  := (SELECT IFNULL(MAX(EXTRA), '') FROM information_schema.COLUMNS
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log'
                     AND COLUMN_NAME = 'id');
SET @id_istext := (SELECT IFNULL(MAX(DATA_TYPE), '') FROM information_schema.COLUMNS
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log'
                     AND COLUMN_NAME = 'id');

SET @sql := IF(@has_table = 1 AND @has_pk = 0 AND @id_istext <> '',
  'ALTER TABLE `zd_system_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`id`)',
  'SET @_noop = 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 2.2 已有主键、但 id 仍不是自增（少见，兼容老式手工建表）→ 只补自增
SET @has_pk2   := (SELECT COUNT(*) FROM information_schema.STATISTICS
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log'
                     AND INDEX_NAME = 'PRIMARY');
SET @id_extra2 := (SELECT IFNULL(MAX(EXTRA), '') FROM information_schema.COLUMNS
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log'
                     AND COLUMN_NAME = 'id');
SET @sql := IF(@has_table = 1 AND @has_pk2 = 1
               AND LOWER(@id_extra2) NOT LIKE '%auto_increment%',
  'ALTER TABLE `zd_system_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT',
  'SET @_noop = 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- =============================================================================
-- 3. 系统设置表：确保 `备注` 列存在（新旧库字段名差异，缺了会导致写入报错）
-- =============================================================================
SET @has_remark_col := (SELECT COUNT(*) FROM information_schema.COLUMNS
                        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_setting'
                          AND COLUMN_NAME = '备注');
SET @sql := IF(@has_remark_col = 0,
  'ALTER TABLE `zd_system_setting` ADD COLUMN `备注` text NULL',
  'SET @_noop = 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- =============================================================================
-- 4. 安全防御开关（4 项，默认全部启用）
--    只在缺失时插入；已存在则保留现值 —— 升级不会把你关掉的防护重新打开。
-- =============================================================================
SET @c1 := (SELECT COUNT(*) FROM `zd_system_setting` WHERE `vars` = 'defense_csrf');
SET @sql := IF(@c1 = 0,
  'INSERT INTO `zd_system_setting` (`vars`, `value`, `备注`) VALUES (''defense_csrf'', ''1'', ''CSRF 防护：后台 POST 做 Origin/Referer 同源校验，危险操作另加令牌'')',
  'SET @_noop = 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c2 := (SELECT COUNT(*) FROM `zd_system_setting` WHERE `vars` = 'defense_xss');
SET @sql := IF(@c2 = 0,
  'INSERT INTO `zd_system_setting` (`vars`, `value`, `备注`) VALUES (''defense_xss'', ''1'', ''XSS 防护：拦截脚本标签与伪协议特征'')',
  'SET @_noop = 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c3 := (SELECT COUNT(*) FROM `zd_system_setting` WHERE `vars` = 'defense_sqli');
SET @sql := IF(@c3 = 0,
  'INSERT INTO `zd_system_setting` (`vars`, `value`, `备注`) VALUES (''defense_sqli'', ''1'', ''SQL 注入防护：拦截 union/select 等注入特征'')',
  'SET @_noop = 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c4 := (SELECT COUNT(*) FROM `zd_system_setting` WHERE `vars` = 'defense_path');
SET @sql := IF(@c4 = 0,
  'INSERT INTO `zd_system_setting` (`vars`, `value`, `备注`) VALUES (''defense_path'', ''1'', ''路径穿越防护：拦截 ../ 与绝对路径特征'')',
  'SET @_noop = 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 4.5 已有开关行但备注为空（老库结构没有备注列）→ 只补文字说明，不动 value
UPDATE `zd_system_setting` SET `备注` = 'CSRF 防护：后台 POST 做 Origin/Referer 同源校验，危险操作另加令牌'
 WHERE `vars` = 'defense_csrf'  AND (`备注` IS NULL OR `备注` = '');
UPDATE `zd_system_setting` SET `备注` = 'XSS 防护：拦截脚本标签与伪协议特征'
 WHERE `vars` = 'defense_xss'   AND (`备注` IS NULL OR `备注` = '');
UPDATE `zd_system_setting` SET `备注` = 'SQL 注入防护：拦截 union/select 等注入特征'
 WHERE `vars` = 'defense_sqli'  AND (`备注` IS NULL OR `备注` = '');
UPDATE `zd_system_setting` SET `备注` = '路径穿越防护：拦截 ../ 与绝对路径特征'
 WHERE `vars` = 'defense_path'  AND (`备注` IS NULL OR `备注` = '');

-- =============================================================================
-- 5. 【可选修复】上传参数 upload_frame 缺失或为空 → 补出厂 6 项
--    仅当该配置不存在或值为空时执行，已有内容（含你自定义过的）一律不动。
-- =============================================================================
SET @uf_cnt := (SELECT COUNT(*) FROM `zd_system_setting` WHERE `vars` = 'upload_frame');
SET @sql := IF(@uf_cnt = 0,
  'INSERT INTO `zd_system_setting` (`vars`, `value`, `备注`) VALUES (''upload_frame'', ''system;png、jpg、gif;../../images/|module;zip;../../module/|softlogo;png;../../images/|program;zip;../../file/|logoview;png、ico;../../file/|imgview;png、jpg、bmp;../../file/|'', ''上传接口参数：接口名;允许后缀;保存目录，多项以 | 分隔'')',
  'UPDATE `zd_system_setting` SET `value` = ''system;png、jpg、gif;../../images/|module;zip;../../module/|softlogo;png;../../images/|program;zip;../../file/|logoview;png、ico;../../file/|imgview;png、jpg、bmp;../../file/|'' WHERE `vars` = ''upload_frame'' AND LENGTH(TRIM(`value`)) = 0');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- =============================================================================
-- 6. 升级结果自检（执行完会输出一张核对表，全部 OK 即升级成功）
-- =============================================================================
SELECT '日志表 id 是否为自增' AS `检查项`,
       IF(LOWER(MAX(EXTRA)) LIKE '%auto_increment%', 'OK', '异常') AS `结果`
  FROM information_schema.COLUMNS
 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log' AND COLUMN_NAME = 'id'
 UNION ALL
SELECT '日志表是否有主键',
       IF((SELECT COUNT(*) FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_log'
              AND INDEX_NAME = 'PRIMARY') > 0, 'OK', '异常')
 UNION ALL
SELECT '设置表是否有 备注 列',
       IF((SELECT COUNT(*) FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'zd_system_setting'
              AND COLUMN_NAME = '备注') > 0, 'OK', '异常')
 UNION ALL
SELECT '四个防御开关是否齐全',
       IF((SELECT COUNT(DISTINCT `vars`) FROM `zd_system_setting`
            WHERE `vars` IN ('defense_csrf','defense_xss','defense_sqli','defense_path')) = 4,
          'OK', '异常')
 UNION ALL
SELECT '上传参数是否非空',
       IF((SELECT COUNT(*) FROM `zd_system_setting`
            WHERE `vars` = 'upload_frame' AND LENGTH(TRIM(`value`)) > 0) = 1, 'OK', '异常');

-- 各防御项当前状态（0=关闭 1=启用）
SELECT `vars` AS `配置项`, `value` AS `当前值（1=启用 0=关闭）`, `备注`
  FROM `zd_system_setting`
 WHERE `vars` LIKE 'defense\_%'
 ORDER BY `vars`;
