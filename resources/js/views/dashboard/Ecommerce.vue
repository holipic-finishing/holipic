<template>
	<div>
		<h1>123123</h1>
	</div>
</template>

<script>
// charts component
import LineChartShadow from "../../components/Charts/LineChartShadow";
import Sales from "../../components/Charts/SalesChartV2";
import LineChartWithArea from "../../components/Charts/LineChartWithArea";

// widgets
import RecentSale from "../../components/Widgets/RecentSales";
import SupportRequest from "../../components/Widgets/SupportRequestV2";
import ToDoList from "../../components/Widgets/ToDoList";
import Invoice from "../../components/Widgets/Invoice";
import RecentOrders from "../../components/Widgets/RecentOrders";
import WeeklySales from "../../components/Widgets/WeeklySales.vue";
import Reviews from "../../components/Widgets/Reviews";
import SocialFeeds from "../../components/Widgets/SocialFeeds";
import TopSelling from "../../components/Widgets/TopSelling";
import NewPost from "../../components/Widgets/AddNewBlog";
import BlogLayoutOne from "../../components/Widgets/BlogLayoutOne";
import BlogLayoutFour from "../../components/Widgets/BlogLayoutFour";
import CategorySale from "../../components/Widgets/CategorySales";
import DeviceShare from "../../components/Widgets/DeviceShare";

import { ChartConfig } from "../../constants/chart-config";

export default {
  components: {
    LineChartShadow,
    RecentSale,
    SupportRequest,
    Sales,
    ToDoList,
    Invoice,
    RecentOrders,
    CategorySale,
    LineChartWithArea,
    WeeklySales,
    Reviews,
    SocialFeeds,
    TopSelling,
    NewPost,
    BlogLayoutOne,
    BlogLayoutFour,
    DeviceShare
  },
  data() {
    return {
      blog: {
        id: 3,
        thumbnail: "/static/img/blog-3.jpg",
        title: "lorem ipsum is simply dummy text",
        body:
          "Consectetur adipisicing elit. Ullam expedita, necessitatibus sit exercitationem aut quo quos inventore similique nulla minima distinctio illo iste dignissimos vero nostrum, magni pariatur delectus natus.",
        date: "1-jun-2018"
      },
      ChartConfig,
      labels: ["A", "B", "C", "D", "E", "F", "J", "K", "L", "M", "N", "P"],
      totalEarnings: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44],
      onlineRevenue: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44],
      newCustomers: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44]
    };
  }
};
</script>
