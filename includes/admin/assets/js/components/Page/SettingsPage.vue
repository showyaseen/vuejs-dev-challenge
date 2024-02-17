<template>
  <div :class="{ 'opacity-20': isLoading }">
    <SectionTitle>
      <SettingIcon></SettingIcon>
      {{ settingsPageTitle }}
    </SectionTitle>

    <Form>
      <InputGroup>
        <Label forInput="rowNumber" :title="__('Number of Rows:', textDomain)"></Label>
        <NumberInput v-on:blur="saveSetting('rowNumber')" v-model="rowNumber" id="rowNumber" name="rowNumber"
          :placeholder="__('rows no', textDomain)"></NumberInput>
        <ErrorMessage v-if="this.hasError.rowNumber">
          {{ messages.rowNumberError }}
        </ErrorMessage>
      </InputGroup>

      <InputGroup>
        <Label forInput="isHuman" :title="__('Human Date Format ?', textDomain)"></Label>
        <CheckboxButton v-on:click="saveSetting('isHuman')" v-model="isHuman" id="isHuman" name="isHuman">
        </CheckboxButton>
      </InputGroup>

      <InputGroup>
        <Label forInput="extraEmail" :title="__('Emails List:', textDomain)"></Label>
      </InputGroup>
      <InputList v-for="(info, index) in extraEmail" :key="index">
        <EmailInput v-on:blur="saveSetting('extraEmail')" :id="'extraEmail-' + index" v-model="extraEmail[index]"
          :placeholder="__('Enter email address here ...', textDomain)">
        </EmailInput>
        <RemoveIcon v-if="index > 0" @click="removeExtraEmail(index)"></RemoveIcon>
        <AddIcon v-if="index >= extraEmail.length - 1 && extraEmail.length < 5" @click="addExtraEmail"></AddIcon>
        <ErrorMessage v-if="this.hasError.extraEmail[index] == true">
          {{ messages.extraEmailError }}
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
      rowNumber: null,
      isHuman: false,
      extraEmail: [],
      hasError: {
        rowNumber: false,
        extraEmail: [],
      },
      settingStore: null,
      settingsPageTitle: __('Settings', vuejs_dev_challenge.text_domain),
      messages: {
        rowNumberError: __('Please enter a valid number of rows.', vuejs_dev_challenge.text_domain),
        extraEmailError: __('Please enter a valid email address.', vuejs_dev_challenge.text_domain),
        saveSuccessful: __('Settings saved successfuly!', vuejs_dev_challenge.text_domain),
      },
      textDomain: vuejs_dev_challenge.text_domain,
    };
  },
  created() {
    // add translation method to component data so it can be access inside component
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
      // clear errors before submit setting
      this.hasError = {
        rowNumber: false,
        extraEmail: [],
      }
      this.settingStore.clearErrors();
      if ('rowNumber' === setting) {
        if (this.settings.rowNumber === this.rowNumber || this.validateRowNumber()) {
          return;
        }
      } else if ('extraEmail' === setting) {
        if (
          JSON.stringify(this.settings.extraEmail) === JSON.stringify(this.extraEmail) || this.validateEmails()) {
          return;
        }
      } else if ('isHuman' === setting) {
        if (this.settings.isHuman === this.isHuman) {
          return;
        }
      } else {
        return;
      }
      let request = {};
      request[setting] = this[setting];
      this.settingStore.saveSettings(request)
    },
    addExtraEmail() {
      this.extraEmail.push('');
    },
    removeExtraEmail(index) {
      this.extraEmail.splice(index, 1);
      this.saveSetting('extraEmail');
    },
    validateRowNumber() {
      this.hasError.rowNumber = false;
      if (this.rowNumber === null || isNaN(this.rowNumber) || this.rowNumber < 1 || this.rowNumber > 5) {
        this.hasError.rowNumber = true;
        return true;
      }
    },
    validateEmails() {
      let inValid = false;
      this.extraEmail.every((email, index) => {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (!email.match(validRegex)) {
          this.hasError.extraEmail[index] = true;
          inValid = true;
        } else {
          this.hasError.extraEmail[index] = false;
        }
        return true;
      });
      return inValid;
    },
    syncFields(settings) {
      if (0 === settings.length) {
        return;
      }
      if (settings.rowNumber) {
        this.rowNumber = settings.rowNumber;
      }
      if (settings.extraEmail) {
        this.extraEmail = Object.assign([], settings.extraEmail);
      }
      this.isHuman = (true === settings.isHuman || "1" == settings.isHuman);
    }
  },
  watch: {
    settings(settings) {
      this.syncFields(settings);
    },
  }
};
</script>
