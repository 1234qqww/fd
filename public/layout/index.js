new Vue({
	delimiters: ['${', '}'],
	el: '.left-bar',
	data: {
		imgUrl:"static/rec.png",
		current:null,
		// navigatUrl:"https://test.vcrush.cn/",
		arr: [{
				 firstTitle: "概况",
				// navigatUrl:"test/test.html",
				secend: [{
						sencendTitle: "会员配置",
						thirdTitle: []
					},
					{
						sencendTitle: "积分兑换会员",
						thirdTitle: []
					},
					{
						sencendTitle: "会员权益",
						thirdTitle: []
					},
					{
						sencendTitle: "签到配置",
						thirdTitle: []
					}, {
						sencendTitle: "广告配置",
						thirdTitle: []
					},
					{
						sencendTitle: "获取积分配置",
						thirdTitle: ["发布获取积分", "分享获取积分"]
					},
					{
						sencendTitle: "帮助中心",
						thirdTitle: ["增加", "设置"]
					}
				]
			}, {
				firstTitle: "首页管理",
			    firstUrl:'/admin/mind',
				secend: [{
					sencendTitle: "分类管理",
					sencendUrl:'/admin/mind'
				},
					{
						sencendTitle: "顶部轮播图",
						secendUrl:'/home/top_banner',
						thirdTitle: []
					},
					{
						sencendTitle: "中部轮播图",
						secendUrl:'/home/cont_banner',
						thirdTitle: []
					}
				]
			}, {
				firstTitle: "二手车",
			    firstUrl:'/admin/usedcar',
			}, {
				firstTitle: "买卖管理",
			    firstUrl:'/admin/business'
			}, {
				firstTitle: "预售管理",
			    firstUrl:'/admin/advanceSale'
		    },
			{
				firstTitle: "帖子审核",
				firstUrl:'/admin/examine'
			},
			{
				firstTitle: "会员中心",
				firstUrl:'/admin/member'
			},
			{
				firstTitle: "用户管理",
				firstUrl:'/admin/user'
			},
			{
				firstTitle: "帮助中心",
				firstUrl:'/admin/helpcenter'
			},
			{
				firstTitle: "关于我们",
				firstUrl:'/admin/about'
			},
			{
				firstTitle: "配置管理",
				firstUrl:'/admin/config'
			},{
				firstTitle: "管理员",
				firstUrl:'/admin/administrators'
			}],
	 secendArr:null,
	 secendCurrent:null,
	},
	mounted:function(){

	},
	methods:{
  
  },
  enterSecend(sindex){
	this.secendCurrent = sindex    
	 
  },
  getSecend(res,index){

	   window.location.href= res.firstUrl+'?a='+index
	  if(this.secendArr!=null){
		  this.secendArr=null
	  }else{
		   this.secendArr = res.secend
	  }
	 
	  
	  
  }
	}
})
