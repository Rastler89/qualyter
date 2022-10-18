import React from "react";
import i18n from "../helpers/i18n";

export default function WorkOrder(props)  {
    const work = props.work;
    
    return (
        <div><strong>{work.code}</strong> - {work.name} - {work.priority}</div>
    )
}