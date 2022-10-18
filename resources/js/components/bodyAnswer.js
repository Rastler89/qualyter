import React from "react";
import i18n from "../helpers/i18n";

export default function BodyAnswer(props) {

    let valoration = props.valoration;
    let stars = props.stars;
    let comment = props.comment;

    return (
        <div className={'accordion-body'}>
            <p>{i18n.t('other.valoration')}: <strong>{valoration}</strong></p>
            <p>{stars}</p>
            <p>{i18n.t('other.comment')}: <br /> {comment }</p>
        </div>
    )
}

