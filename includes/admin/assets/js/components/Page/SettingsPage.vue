<template>
  <div :class="{ 'opacity-20': isLoading }">
    <SectionTitle>
      <SettingIcon></SettingIcon>
      {{ settingsPageTitle }}
    </SectionTitle>

    <Form>
      <InputGroup>
        <Label forInput="row_number" :title="__('Number of Rows:', textDomain)"></Label>
        <NumberInput
          v-on:blur="saveSetting('row_number')"
          v-model="row_number"
          id="row_number"
          name="row_number"
          :placeholder="__('rows no', textDomain)">
        </NumberInput>
        <ErrorMessage v-if="this.hasError.row_number">
          {{ messages.row_numberError }}
        </ErrorMessage>
      </InputGroup>

      <InputGroup>
        <Label forInput="is_human" :title="__('Human Date Format ?', textDomain)"></Label>
        <CheckboxButton
          v-on:click="saveSetting('is_human')"
          v-model="is_human"
          id="is_human"
          name="is_human">
        </CheckboxButton>
      </InputGroup>

      <InputGroup>
        <Label forInput="extra_email" :title="__('Emails List:', textDomain)"></Label>
      </InputGroup>
      <InputList v-for="(info, index) in extra_email" :key="index">
        <EmailInput
          v-on:blur="saveSetting('extra_email')"
          :id="'extra-email-' + index"
          v-model="extra_email[index]"
          :placeholder="__('Enter email address here ...', textDomain)">
        </EmailInput>
        <RemoveIcon v-if="index > 0" @click="removeextraEmail(index)"></RemoveIcon>
        <AddIcon v-if="index >= extra_email.length - 1 && extra_email.length < 5" @click="addextraEmail"></AddIcon>
        <ErrorMessage v-if="this.hasError.extra_email[index] == true">
          {{ messages.extra_emailError }}
        </ErrorMessage>
      </InputList>

      <ErrorMessage v-for="error in Object.keys(errors)">
        {{ errors[error] }}
      </ErrorMessage>

      <SuccessMessage v-if="savedSucess">
        {{ messages.saveSuccessful }}
      </SuccessMessage>
    </Form>

    <Spinner v-if="isLoading"></Spinner>
  </div>
</template>

<script>
/**
 * AdminDashboard Plugin - SettingsPage Component
 *
 * @package       ytaha-admin-dashboard
 * @description   This component is part of the AdminDashboard plugin, an experimental learning tool that showcases
 *                an admin dashboard integrating external data into tables and charts. This file defines the SettingsPage
 *                component, responsible for rendering settings forms for customizing date formats and managing email lists.
 *
 */
import Form from '../Form/Form.vue';
import SectionTitle from '../Form/SectionTitle.vue';
import FormFooter from '../Form/FormFooter.vue';
import InputGroup from '../Form/InputGroup.vue';
import InputList from '../Form/InputList.vue';
import EmailInput from '../Form/EmailInput.vue';
import NumberInput from '../form/NumberInput.vue';
import Label from '../form/Label.vue';
import CheckboxButton from '../Form/CheckboxButton.vue';
import ErrorMessage from '../Form/ErrorMessage.vue';
import SuccessMessage from '../Form/SuccessMessage.vue';
import Spinner from '../Form/Spinner.vue';

import AddIcon from '../Icons/AddIcon.vue'
import RemoveIcon from '../Icons/RemoveIcon.vue';
import SettingIcon from '../Icons/SettingIcon.vue';

import { useSettingStore } from "../../stores/settings";
const { __ } = wp.i18n;

export default {
  name: "SettingsPage",
  props: {
    settingStore: Object,
  },
  components: {
    Form,
    SectionTitle,
    FormFooter,
    InputGroup,
    InputList,
    NumberInput,
    EmailInput,
    Label,
    CheckboxButton,
    AddIcon,
    RemoveIcon,
    SettingIcon,
    ErrorMessage,
    SuccessMessage,
    Spinner
  },
  data() {
    return {
      row_number: null,
      is_human: false,
      extra_email: [],
      hasError: {
        row_number: false,
        extra_email: [],
      },
      settingStore: null,
      settingsPageTitle: __('Settings', admin_dashboard.text_domain),
      messages: {
        row_numberError: __('Please enter a valid number of rows.', admin_dashboard.text_domain),
        extra_emailError: __('Please enter a valid email address.', admin_dashboard.text_domain),
        saveSuccessful: __('Settings saved successfully!', admin_dashboard.text_domain),
      },
      textDomain: admin_dashboard.text_domain,
    };
  },
  created() {
    // Add translation method to component data so it can be accessed inside the component
    this.__ = __;
    this.settingStore = useSettingStore();
  },
  mounted() {
    this.syncFields(this.settingStore.settings);
  },
  computed: {
    settings() {
      return this?.settingStore?.settings;
    },
    errors() {
      return this.settingStore.errors;
    },
    savedSucess() {
      return this.settingStore.savedSucess;
    },
    isLoading() {
      return this.settingStore.isLoading;
    }
  },
  methods: {
    saveSetting(setting) {
      // Clear errors before submitting settings
      this.hasError = {
        row_number: false,
        extra_email: [],
      }
      this.settingStore.clearErrors();
      if ('row_number' === setting) {
        if (this.settings.row_number === this.row_number || this.validaterowNumber()) {
          return;
        }
      } else if ('extra_email' === setting) {
        if (JSON.stringify(this.settings.extra_email) === JSON.stringify(this.extra_email) || this.validateEmails()) {
          return;
        }
      } else if ('is_human' === setting) {
        if (this.settings.is_human === this.is_human) {
          return;
        }
      } else {
        return;
      }
      let request = {};
      request[setting] = this[setting];
      this.settingStore.saveSettings(request)
    },
    addextraEmail() {
      this.extra_email.push('');
    },
    removeextraEmail(index) {
      this.extra_email.splice(index, 1);
      this.saveSetting('extra_email');
    },
    validaterowNumber() {
      this.hasError.row_number = false;
      if (this.row_number === null || isNaN(this.row_number) || this.row_number < 1 || this.row_number > 5) {
        this.hasError.row_number = true;
        return true;
      }
    },
    validateEmails() {
      let inValid = false;
      this.extra_email.every((email, index) => {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (!email.match(validRegex)) {
          this.hasError.extra_email[index] = true;
          inValid = true;
        } else {
          this.hasError.extra_email[index] = false;
        }
        return true;
      });
      return inValid;
    },
    syncFields(settings) {
      if (0 === settings.length) {
        return;
      }
      if (settings.row_number) {
        this.row_number = settings.row_number;
      }
      if (settings.extra_email) {
        this.extra_email = Object.assign([], settings.extra_email);
      }
      this.is_human = (true === settings.is_human || "1" == settings.is_human);
    }
  },
  watch: {
    settings(settings) {
      console.log('this.settingStore.settings', this.settingStore.settings);
      this.syncFields(settings);
    },
  }
};
</script>
