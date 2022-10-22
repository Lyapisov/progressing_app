import {BaseForm} from "../base-form";
import {TextField} from "../text-field";
import {DateField} from "../date-field";

export class PublicationFormBuilder {
  public static createDefault(): BaseForm<string>[] {
    return [
      new TextField({
        key: 'title',
        label: 'title',
        required: true,
        order: 1
      }),
      new TextField({
        key: 'text',
        label: 'text',
        required: true,
        order: 2
      }),
      new TextField({
        key: 'imageId',
        label: 'image',
        required: false,
        value: '1',
        order: 3
      }),
    ]
  }

  public static createWithValues(values: {
    firstName?: string;
    lastName?: string;
    fatherName?: string;
    birthday?: string;
    phone?: string;
    address?: string;
  }): BaseForm<string>[] {
    return [
      new TextField({
        key: 'firstName',
        label: 'First name',
        required: true,
        value: values.firstName || '',
        order: 1,
      }),
      new TextField({
        key: 'lastName',
        label: 'Last name',
        required: false,
        value: values.lastName || '',
        order: 2
      }),
      new TextField({
        key: 'fatherName',
        label: 'Father name',
        required: false,
        value: values.fatherName || '',
        order: 3
      }),
      new DateField({
        key: 'birthday',
        label: 'Birthday',
        required: true,
        value: values.birthday,
        order: 4
      }),
      new TextField({
        key: 'phone',
        label: 'Phone number',
        required: false,
        value: values.phone || '',
        order: 5
      }),
      new TextField({
        key: 'address',
        label: 'Address',
        required: false,
        value: values.address || '',
        order: 6
      }),
    ]
  }
}
