<template>
    <ul class="list-none mx-5">
        <li v-for="email in emails">
            <Email :email="email">
                <EmailIcon></EmailIcon>
                {{ email }}
            </Email>
        </li>
    </ul>
</template>
<script>
import Email from './Email.vue';
import EmailIcon from '../Icons/EmailIcon.vue';
export default {
	name: 'EmailList',
    props: {
        emails: Array,
    },
    components: {
        Email,
        EmailIcon
    }
};
</script>