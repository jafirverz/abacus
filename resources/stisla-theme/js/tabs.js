$(".tabs-wrap").each(function() {
	var $myTabs = $(this);

	$myTabs.find("ul.tabs li").click(function() {
		var $this = $(this);

		$this.addClass("active").siblings().removeClass("active");
		$myTabs.find(".tab-content").removeClass('active');

		var activeTab = $this.find("a").attr("href");
		$(activeTab).addClass('active');

		return false;
	});
});