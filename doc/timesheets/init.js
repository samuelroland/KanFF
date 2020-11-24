project_id = 'PWB2AGDC'
team = ["Samuel", "Benoît"]

inpProject.value = project_id

if (typeof(inpPerson) !== 'undefined') {
    team.forEach(element => {
        opt = document.createElement('option')
        opt.text = element
        inpPerson.appendChild(opt)
    });
}
