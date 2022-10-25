export class Status {
  public readonly name: string;

  constructor(name: string) {
    this.name = name;
  }

  get displayedStatusName(): string {
    if (this.name === 'draft') {
      return 'DRAFT';
    } else if (this.name === 'published') {
      return 'PUBLISHED';
    } else if (this.name === 'archived') {
      return 'ARCHIVED';
    } else if (this.name === 'banned') {
      return 'BANNED'
    } else {
      return 'ERROR_STATUS';
    }
  }

  get displayedColor(): string {
    if (this.name === 'draft') {
      return '#f6ff00';
    } else if (this.name === 'published') {
      return '#69f0ae';
    } else if (this.name === 'archived') {
      return '#000000';
    } else if (this.name === 'banned') {
      return '#ff0000'
    } else {
      return 'ERROR_STATUS';
    }
  }
}
