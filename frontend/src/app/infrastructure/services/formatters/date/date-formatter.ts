import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class DateFormatter {
  public createDateStringFromTimestamp(timestamp: number): string
  {
    const date = new Date(timestamp * 1000);

    const year = date.getFullYear().toString();
    let month = (date.getMonth()+1).toString();
    let day = date.getDate().toString();

    if (month.length < 2)
      month = '0' + month;
    if (day.length < 2)
      day = '0' + day;

    return year + '-' + month + '-' + day;
  }
}
