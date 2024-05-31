<script lang="ts" setup>
import { computed, ref } from 'vue';
import PermissionTable from "@admin/modules/user/views/PermissionTable.vue";
import type { IRole } from "@admin/modules/user/interfaces/IRole";
import {Role} from "@admin/modules/user/services/role";
import {useRoleStore} from "@admin/modules/user/store/role";
import Card from "@ui/Card.vue";
import { Permission } from '@admin/modules/user/services/permission';
import { usePermissionStore } from '@admin/modules/user/store/permission';
import type { IPermission } from '@admin/modules/user/interfaces/IPermission';

let menu = ref({
    roles: true,
})

Role.getAll()
const roleStore = useRoleStore()
const roles = computed<Array<IRole>>(() => roleStore.getList)

Permission.getAll()
const permissionStore = usePermissionStore()
const permissions = computed<Array<IPermission>>(() => permissionStore.getList)

const changeTab = (name: string) => Object.keys(menu.value).map((key: string) => menu.value[key] = key === name)
</script>

<template>
    <div>
        <ul uk-tab>
            <li :class="{'uk-active': menu.roles}"><a @click="changeTab('roles')" href="#">roles</a></li>
        </ul>
    </div>

    <div v-if="roles.length >= 0">
        <div v-for="(role, key) in roles" :key="key">
            <p>{{ role.name.charAt(0).toUpperCase() + role.name.slice(1) }}</p>
            <PermissionTable 
                v-if="menu.roles"
                :role="role"
                :permissions="permissions"
                :active-permissions="role.permissions"
            />
        </div>
    </div>
    <Card v-else>Loading...</Card>
</template>