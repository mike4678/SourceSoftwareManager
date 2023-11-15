# SourceSoftwareManager 说明文档
Source Software Manager Version Infomation

一、开发者注
====================================================
由于Android原因，目前新版本开发已全面迁移至火山软件开发平台中，后续版本也将在火山中继续开发，易语言版本将不再更新

部署方式及功能界面仍然相同，同时针对火山版本，重写代码，并对其中的部分功能进行优化，相信全新的火山版本可以给你们一个不一样的体验！

目前火山版本仍处于测试版，如果您有任何意见和建议，非常感谢您与我沟通

Server端：已开发完成，基础测试正常，注意：如果需要在Server 2012以下的系统使用，需使用VS2017进行编译，如果为2012以上的版本，可正常使用VS2019进行编译

Manager端：已开发完成，基础测试正常

Client端：Beta版，仍在加紧开发修复Bug中

Android端：待客户端开发完成后，开始编写


二、部署方式
====================================================

2.1 易语言版 
====================================================

客户端，服务端及管理端支持一键部署

1.服务端及管理端并放置同一个目录下

2.服务端初次使用会提示初始化，按照窗口内容填入内容，点击“连接测试”，返回连接成功后，点击保存按钮，生效Mysql配置信息，然后点击初始化按钮，软件会自动根据Mysql版本创建对应的数据表，提示初始化完成后，服务端部署完成，此时点击“启动”，服务端就开始工作了

3.
(1.2.6之前版本)
客户端修改核心集 -> HPSocket程序集 -> 服务连接 中的服务器地址，然后编译即可

(1.2.6之后版本)
客户端修改config.ini配置文件中的
[system]
ConfigServer=服务器地址
ConfigServerPort=7777 服务器端口号
信息即可

4.服务器上运行与服务端同目录下的管理端，然后设定软件包参数，用户请求文件包地址必须为可以通过web能访问到的地址，本地源路径为软件的本地路径,内部版本号必须跟客户端一致(该值用于判断客户端是否需要更新)

例子解释：

假如我服务器上D:\Soft\这个目录为软件的地址，则本地源路径就为：D:\Soft\

用户请求文件包地址则是我上述的路径可以通过web访问到的地址，比如我将d:\soft\通过IIS设置成可以通过admin.csource.com.cn/ 来访问，那么用户请求文件包地址就是：http://admin.csource.com.cn


Web管理端部署方式及相关说明：

1.Web管理端目前仅在IIS下Chrome内核下测试通过

2.1.部署很简单，在IIS中添加整个目录，然后在Mysql中导入install.sql文件（注：数据库必须与服务端为同一个数据库，例如服务端的数据库表为：TestDB，则Web管理端导入也必须导入到TestDB表中）（1.0.1之前版本）

2.2.部署很简单，在IIS中添加整个目录即可（1.0.1之前版本）

3.到kernl目录下，找到conf.php文件，用记事本等软件打开，按照说明修改里面的值，然后保存

4.然后访问 IP地址/index.php 或者 IP地址/admin/index.php ,输入用户名：admin 密码：admin，即可正常管理

====================================================

2.2 火山版

====================================================




三、更新方式
====================================================

软件更新采用的是静默更新方式，客户端通过提交NVersion中的值到服务端，服务端判断是否需要更新，并根据情况推送更新包给到客户端

如果检测到更新，则客户端下载更新包并缓存再update目录下，待下一次运行时自动执行更新操作

详细更新修改方法

1.客户端代码变更后，到“常量数据表”中，修改Version及BuildData信息，然后将NVersion 修改为当前数值更高一个值，比如原本是4，可以更改成5，6...，该数字不能高于服务端上的数字

2.服务器上运行管理端，然后修改版本信息中的内部版号，然后点击保存配置即可


四、安卓客户端说明
====================================================

当前安卓客户端基于火山编程开发，当前版本仅为测试版本，不作为最终呈现版本

安卓客户端基于网页版实现，也即是如果需要使用安卓客户端，则需要提前搭建好网页端


五、版本信息
====================================================

#2023.11.08

Data：Add Version

Client、Server、Manager Upload 火山 Version

#2022.12.01

Data：Add Function & Fix Bug

Client Version Update To v1.2.6

Server Version Update To v1.2.2

Manager Version Update To v1.1.2

Web Client Update To v1.0.2

#2022.09.08

Data：Add Function & Fix Bug

Client Version Update To v1.2.5

Server Version Update To v1.2.0

#2022.08.12

Data：Fix Bug + Update Web

Web Client Update To v1.0.1

#2022.08.01

Data：Fix Bug

Client Version Update To v1.2.4

#2022.07.22

Data：Add WebManager

#2022.06.20

Data: Fix Bug

Client Version Update To v1.2.3

Server Manager Program Version Update To v1.1.1

Server Version Update To v1.1.6

#2022.05.12

Data: Fix Bug

Client Version Update To v1.2.0

Server Manager Program Version Update To v1.1.0

Server Version Update To v1.1.5

====================================================

1.易语言版 
====================================================

  客户端
=====================================================
Version 1.2.6

1.针对发布版本，修改服务器地址的设置位置

Version 1.2.5

1.新增未知文件后缀推荐程序

2.新增针对SourceSoftManager://协议的支持

Version 1.2.4

1.新增软件背景选择界面，支持选择本地图片背景、Bing动态图片背景、纯色背景

2.修正之前的检查下载引擎报错的Bug

Version 1.2.3

1.新增下载安装完成后不删除安装包选项

2.修复重新安装无效的Bug

3.修复有特殊字符下创建桌面快捷方式异常

Version 1.2.0

1.修改下载引擎从迅雷更换为aria2

2.修改更新为可选择

3.软件支持自定义背景

4.软件信息界面新增版本更新说明

5.界面细节优化

6.Bug修复及代码优化

  管理端
=====================================================
Version 1.1.5

1.新增手机软件的管理

Version 1.1.1

1.修复编辑软件信息时提示“修改失败”的Bug

2.修改介绍文字保存方式（由于修改了介绍保存方式，故用户使用客户端也需要进行对应更新，对应版本：客户端 V1.2.3）

3.新增下载数显示

Version 1.1.0

1.修复初次使用时无法保存数据的Bug

2.软件新增界面增加版本更新说明选项

   Web管理端
=====================================================
Version 1.0.2

1.Bug修复

2.新增初次使用初始化界面

Version 1.0.1

*该版本由于重新设计，因此与1.0.0版本不兼容，部分参数可能需要重新设定

1.重新设计后的登录界面

2.重新设计后的后台管理界面

3.新增Web 版客户端界面

4.多个Bug修复及优化

Version 1.0.0

基于网页端的管理程序来了，与EXE程序相同的操作方式，文件容量、文件Hash、目录标识支持自动生成

  服务端
=====================================================
Version 1.2.2

1.优化修改数据库安装

Version 1.2.0

1.针对手机端可能存在问题进行了修复

Version 1.1.6

1.新增下载数统计

Version 1.1.5

1.针对不同Mysql版本可能会出现无法初始化的Bug进行修复

====================================================

2.火山版

====================================================


