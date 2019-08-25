<template>
	<div class="Bookmarks__Breadcrumbs">
		<a class="icon-home" @click="onSelectHome" />
		<span class="icon-breadcrumb" />
		<template v-if="$route.name === 'folder'">
			<template v-for="folder in folderPath">
				<a
					href="#"
					:key="'a' + folder.id"
					@click.prevent="onSelectFolder(folder.id)"
					>{{ folder.title }}</a
				>
				<span :key="'b' + folder.id" class="icon-breadcrumb" />
			</template>
		</template>
		<template v-if="$route.name === 'tags'">
			<span class="icon-tag" />
			<Multiselect
				class="Bookmarks__Breadcrumbs__Tags"
				:value="tags"
				:autoLimit="false"
				:limit="7"
				:options="allTags"
				:multiple="true"
				@input="onTagsChange"
			/>
		</template>
		<button
			v-if="$route.name === 'folder' || $route.name === 'home'"
			class="button icon-add Bookmarks__Breadcrumbs__AddFolder"
			@click="onAddFolder"
		></button>
		<div class="Bookmarks__Breadcrumbs__ViewMode">
			<button @click="onSetGridView" class="icon-toggle-pictures"></button>
			<button @click="onSetListView" class="icon-toggle-filelist"></button>
		</div>
	</div>
</template>
<script>
import { Multiselect } from 'nextcloud-vue';
import { actions, mutations } from '../store';

export default {
	name: 'Breadcrumbs',
	components: { Multiselect },
	props: {},
	data() {
		return {
			url: ''
		};
	},
	computed: {
		allTags() {
			return this.$store.state.tags.map(tag => tag.name);
		},
		tags() {
			const tags = this.$route.params.tags;
			if (!tags) return [];
			return tags.split(',');
		},
		folderPath() {
			const folder = this.$route.params.folder;
			if (!folder) return [];
			return this.$store.getters.getFolder(folder).reverse();
		}
	},
	created() {},
	methods: {
		onSelectHome() {
			this.$router.push({ name: 'home' });
		},
		onTagsChange(tags) {
			this.$router.push({ name: 'tags', params: { tags: tags.join(',') } });
		},

		onSelectFolder(folder) {
			this.$router.push({ name: 'folder', params: { folder } });
		},

		onAddFolder() {
			this.$store.commit(mutations.DISPLAY_NEW_FOLDER, true);
		},

		onSetGridView() {
			this.$store.commit(mutations.SET_VIEW_MODE, 'grid');
		},

		onSetListView() {
			this.$store.commit(mutations.SET_VIEW_MODE, 'list');
		}
	}
};
</script>
<style>
.Bookmarks__Breadcrumbs {
	padding: 2px 8px;
	display: flex;
	align-items: center;
	position: fixed;
	z-index: 100;
	background: var(--color-main-background-translucent);
	right: 0;
	left: 300px;
}
@media only screen and (max-width: 768px) {
	.Bookmarks__Breadcrumbs {
		padding-left: 52px;
		left: 0;
	}
}
.Bookmarks__Breadcrumbs + * {
	margin-top: 50px;
}
.Bookmarks__Breadcrumbs > * {
	display: inline-block;
	flex: 0;
	height: 30px;
	padding: 7px;
}
.Bookmarks__Breadcrumbs > *:not(.icon-breadcrumb) {
	opacity: 0.6;
	min-width: 30px;
}
.Bookmarks__Breadcrumbs > a:hover {
	opacity: 1;
}
.Bookmarks__Breadcrumbs__Tags {
	width: 300px;
	flex: 1;
}
.Bookmarks__Breadcrumbs__Tags .multiselect__tags {
	border-top: none !important;
	border-left: none !important;
	border-right: none !important;
}
.Bookmarks__Breadcrumbs__AddFolder {
	margin-left: 5px;
}
.Bookmarks__Breadcrumbs__ViewMode {
	flex: 2;
	display: flex;
	flex-direction: row-reverse;
	padding: 0;
}
</style>