export class PublicationFormData {
  public readonly title: string;
  public readonly text: string;
  public readonly imageId: string;

  constructor(
    title: string,
    text: string,
    imageId: string,
  ) {
    this.title = title;
    this.text = text;
    this.imageId = imageId;
  }
}
