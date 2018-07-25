</pre><p><pre name="code" class="php"><pre name="code" class="php"><?php
class user
{
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function logout()
	{
		session_start();
		//启用单点登录的时候还要到统一认证中心注销  && isset($_SESSION['phpCAS']) && $_SESSION['phpCAS']['auth_checked'] == '1' 
		
		//引人cas
		include_once './CAS.php';
		
		// initialize phpCAS			
		//phpCAS::client(CAS_VERSION_2_0,'服务地址',端口号,'cas的访问地址');
		phpCAS::client(CAS_VERSION_2_0,"127.0.0.1","80","/cas");
		
		//方法一:登出成功后跳转的地址 -- 登出方法中加此句
		/*
		phpCAS::setServerLoginUrl("https://localhost:80/cas/logout?embed=true&service=http://localhost/phpCasClient/user.php?a=login");
		//no SSL validation for the CAS server
		phpCAS::setNoCasServerValidation();
		phpCAS::logout();*/
 
		//方法二:退出登录后返回地址 -- 登出方法中加此句
		phpCAS::setNoCasServerValidation();$param=array("service"=>"http://localhost/phpCasClient/user.php?a=login");
		phpCAS::logout($param);
	}
	
	/** 
	 * @desc LoginCas()单点登陆 
	 */
	public function loginCas(){
		Header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
		//引人cas
		include './CAS.php';
		// initialize phpCAS 
		//phpCAS::client(CAS_VERSION_2_0,'服务地址',端口号,'cas的访问地址');
		phpCAS::client(CAS_VERSION_2_0,"localhost","80","/cas",true);
 
		//可以不用，用于调试，可以通过服务端的cas.log看到验证过程。
		// phpCAS::setDebug();
		//登陆成功后跳转的地址 -- 登陆方法中加此句
		phpCAS::setServerLoginUrl("https://localhost:80/cas/login?embed=true&cssUrl=http://localhost/phpCasClient/style/login.css&service=http://localhost/phpCasClient/user.php?a=loginCas");
		//no SSL validation for the CAS server 不使用SSL服务校验
		phpCAS::setNoCasServerValidation();
		//这里会检测服务器端的退出的通知，就能实现php和其他语言平台间同步登出了
		phpCAS::handleLogoutRequests();
		
		if(phpCAS::checkAuthentication()){
			//获取登陆的用户名
			$username=phpCAS::getUser();
			//用户登陆成功后,采用js进行页面跳转
			echo "<script language=\"javascript\">parent.location.href='http://localhost/phpCasClient/home.php';</script>";
		}else{
			// 访问CAS的验证
			phpCAS::forceAuthentication();
		}
		exit;
	}
}
?>