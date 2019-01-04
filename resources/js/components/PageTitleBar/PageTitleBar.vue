<template>
	<v-breadcrumbs class="pl-0 pr-0 pt-0">
		<h2 class="text-capitalize mb-0">{{$t(pageTitle)}}</h2>
		<v-spacer></v-spacer>
		<!-- <v-breadcrumbs-item>
			{{pageBreadcrumb}}
		</v-breadcrumbs-item> -->
	</v-breadcrumbs>
</template>

<script>
export default {
  computed: {
    pageTitle() {
      return this.$breadcrumbs[0].meta.title;
    },
    pageBreadcrumb() {
      return this.$breadcrumbs[0].meta.breadcrumb;
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
