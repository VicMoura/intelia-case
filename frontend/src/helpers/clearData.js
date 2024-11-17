export function clearData(data, otherData) {
    let newData = {};
  
    if (data && Object.keys(data).length > 0) {
      for (const key in data) {
        if (Object.prototype.hasOwnProperty.call(data, key) && otherData[key] !== data[key]) {
          newData[key] = data[key];
        }
      }
    }
  
    return newData;
  }
  