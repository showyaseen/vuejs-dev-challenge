<template>
  <ContentCard>
    <HeadTitle>
      <SettingIcon></SettingIcon>
      Settings
    </HeadTitle>

    <Form>
      <InputGroup>
        <Label forInput="rowNumber" title="Number of Rows:"></Label>
        <NumberInput v-model="rowNumber" id="rowNumber" name="rowNumber" placeholder="rows no"></NumberInput>
        <ErrorMessage v-if="this.hasError.rowNumber">
          Please enter a valid number of rows.
        </ErrorMessage>
      </InputGroup>

      <InputGroup>
        <Label forInput="isHumanDate" title="Human Date Format ?"></Label>
        <CheckboxButton v-model="isHumanDate" id="isHumanDate" name="isHumanDate"></CheckboxButton>
      </InputGroup>

      <Label forInput="extraEmail" title="Emails List:"></Label>
      <InputGroup v-for="(info, index) in extraEmail" :key="index">
        <EmailInput :id="'extraEmail-' + index" v-model="extraEmail[index]" placeholder="Enter email address here ...">
        </EmailInput>
        <RemoveIcon v-if="index > 0" @click="removeExtraEmail(index)"></RemoveIcon>
        <AddIcon v-if="index >= extraEmail.length - 1" @click="addExtraEmail"></AddIcon>
        <ErrorMessage v-if="this.hasError.extraEmail[index] == true">
          Please enter a valid email address.
        </ErrorMessage>
      </InputGroup>


      <FormFooter>
        <Button @click="submitForm" color="blue">
          Save Settings
        </Button>
      </FormFooter>


    </Form>
  </ContentCard>
</template>

<script>
import ContentCard from '../Layout/ContentCard.vue'

import Form from '../Form/Form.vue';
import HeadTitle from '../Form/HeadTitle.vue';
import FormFooter from '../Form/FormFooter.vue';
import InputGroup from '../Form/InputGroup.vue';
import EmailInput from '../Form/EmailInput.vue';
import NumberInput from '../form/NumberInput.vue';
import Label from '../form/Label.vue';
import Button from '../Form/Button.vue';
import CheckboxButton from '../Form/CheckboxButton.vue';
import ErrorMessage from '../Form/ErrorMessage.vue';

import AddIcon from '../Icons/AddIcon.vue'
import RemoveIcon from '../Icons/RemoveIcon.vue';
import SettingIcon from '../Icons/SettingIcon.vue';

export default {
  components: {
    ContentCard,
    Form,
    HeadTitle,
    FormFooter,
    InputGroup,
    NumberInput,
    EmailInput,
    Label,
    Button,
    CheckboxButton,
    AddIcon,
    RemoveIcon,
    SettingIcon,
    ErrorMessage,
  },
  data() {
    return {
      rowNumber: 1,
      isHumanDate: false,
      extraEmail: [''],
      hasError: {
        rowNumber: false,
        extraEmail: [],
      },
    };
  },
  methods: {
    submitForm() {
      this.validateRowNumber();
      this.validateEmails();
      if (
        this.hasError.rowNumber
        || this.hasError.extraEmail.filter((error) => true === error).length > 0
      ) {
        return;
      }

      // submission logic TODO
    },
    addExtraEmail() {
      this.extraEmail.push('');
    },
    removeExtraEmail(index) {
      this.extraEmail.splice(index, 1);
    },
    validateRowNumber() {
      this.hasError.rowNumber = false;
      if (this.rowNumber === null || isNaN(this.rowNumber) || this.rowNumber < 1) {
        this.hasError.rowNumber = true;
        return;
      }
    },
    validateEmails() {
      this.extraEmail.every((email, index) => {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (!email.match(validRegex)) {
          this.hasError.extraEmail[index] = true;
        } else {
          this.hasError.extraEmail[index] = false;
        }
        return true;
      });
    }
  },
  watch: {
    rowNumber(value) {
      console.log('watch row')
      this.validateRowNumber()
    },
    extraEmail: {
      handler(value) {
        console.log('watch emails')
        this.validateEmails()
      },
      deep: true
    },
  }
};
</script>
