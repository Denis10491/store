<script lang="ts" setup>
import PermissionTableItem from "@admin/modules/user/components/PermissionTableItem.vue";
import type { IPermission } from "@admin/modules/user/interfaces/IPermission";
import { findItemById } from "@helpers/functions";
import type { IRole } from "@admin/modules/user/interfaces/IRole";

const props = defineProps<{
    role: IRole
    permissions: Array<IPermission>,
    activePermissions: Array<IPermission>
}>()
</script>

<template>
    <table class="uk-table uk-table-divider uk-table-middle uk-table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <PermissionTableItem
                v-for="(permission, key) in props.permissions"
                :key="key"
                :role="role"
                :permission="permission"
                :is-active="findItemById(props.activePermissions, permission.id)"
            />
        </tbody>
    </table>
</template>

<style scoped>
.uk-table th {
    text-align: start;
}
</style>