<script lang="ts" setup>
import type { IPermission } from "@admin/modules/user/interfaces/IPermission"
import type { IRole } from "@admin/modules/user/interfaces/IRole";
import { Role } from "@admin/modules/user/services/role";

const props = defineProps<{
    role: IRole,
    permission: IPermission,
    isActive: boolean,
}>()

function update(event: ToggleEvent) {
    if (event.target.checked === true) {
        Role.addPermission(props.role.id, props.permission.id)
    }

    if (event.target.checked === false) {
        Role.removePermission(props.role.id, props.permission.id)
    }
}
</script>

<template>
    <tr class="uk-height-1-1">
        <td>{{ props.permission.id }}</td>
        <td>{{ props.permission.name.replaceAll('-', ' ') }}</td>
        <td>
            <div class="uk-margin">
                <label><input class="uk-checkbox" type="checkbox" :checked="props.isActive" @change="update"></label>
            </div>
        </td>
    </tr>
</template>